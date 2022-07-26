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

            return true;
        }

        return false;
    }

    public function logout(): void
    {
        $session = $this->requestStack->getSession();
        $session->invalidate();
        return;
    }
}
