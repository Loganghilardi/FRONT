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

    public function isLogged(): bool
    {
        $session = $this->requestStack->getSession();

        if($session->get('token') !== null) {
            return true;
        } 

        return false;
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
            'https://ouiquit-api.herokuapp.com/api/users',
            ['headers' => $header]
        );

        return $response->toArray();
    }

    public function getUser(int $id): array
    {
        $session = $this->requestStack->getSession();

        $token = $session->get('token');
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $response = $this->client->request(
            'GET',
            'https://ouiquit-api.herokuapp.com/api/users/' . $id,
            ['headers' => $header]
        );

        return $response->toArray();
    }

    public function deleteUser(int $id): void
    {
        $session = $this->requestStack->getSession();

        $token = $session->get('token');
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $this->client->request(
            'DELETE',
            'https://ouiquit-api.herokuapp.com/api/users/' . $id,
            ['headers' => $header]
        ); 

    }

    public function createUser(array $data): void
    {
        
        $this->client->request(
            'POST',
            'https://ouiquit-api.herokuapp.com/api/users',
            ['json' => $data],
        ); 

    }

    public function updateUser(int $id, array $data): void
    {
        
        $session = $this->requestStack->getSession();

        $token = $session->get('token');
        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $this->client->request(
            'PUT',
            'https://ouiquit-api.herokuapp.com/api/users/' . $id,
            ['headers' => $header, 'json' => $data]
        ); 

    }
}
