<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
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

    public function getToken($data): bool
    {
        $session = $this->requestStack->getSession();

        $response = $this->client->request(
            'POST',
            'http://127.0.0.1:8000/api/login',
            [
                'json' => [
                    'email' => $data['username'],
                    'password' => $data['password'],
                ],
            ]
        );
        if ($response->getStatusCode() === 200) {
            $session->set('token', $response->toArray()['token']);

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
