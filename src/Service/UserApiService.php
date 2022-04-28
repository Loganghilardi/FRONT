<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class UserApiService
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

    public function getUsers(): array
    {
        $session = $this->requestStack->getSession();

        $token = $session->get('token');
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $response = $this->client->request(
            'GET',
            'http://127.0.0.1:8000/api/users',
            ['headers' => $header]
        );

        return $response->toArray();
    }
}