<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class AuthApiService
{
    private $client;
    private $requestStack;

    public function __construct(
        HttpClientInterface $client,
        RequestStack $requestStack
    ) {
        $this->client = $client;
        $this->requestStack = $requestStack;
    }

    public function login($data): bool
    {
        $session = $this->requestStack->getSession();

        $response = $this->client->request(
            'POST',
            'https://ouiquit-api.herokuapp.com/api/login',
            [
                'json' => [
                    'email' => $data['username'],
                    'password' => $data['password'],
                ],
            ]
        );
        if ($response->getStatusCode() === 200) {
            $session->set('token', $response->toArray()['token']);
            $session->set('username',  $data['username']);
            $test = $this->getUserLogged($data['username']);
            if (!in_array('ROLE_ADMIN', $test['roles']))
            {
                return false;
            }
            $session->set('userLogged', $test);
            
            return true;
        }

        return false;
    }

    public function getUserLogged(string $userIdentifier): array
    {
        $session = $this->requestStack->getSession();

        $token = $session->get('token');
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $response = $this->client->request(
            'GET',
            'https://ouiquit-api.herokuapp.com/api/users?email=' . $userIdentifier,
            ['headers' => $header]
        );

        return $response->toArray()[0];
    }

    public function logout(): void
    {
        $session = $this->requestStack->getSession();
        $session->invalidate();
        return;
    }
}
