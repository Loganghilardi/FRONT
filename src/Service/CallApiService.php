<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getBookData(): array

    {
        $header = [
            'Authorization' => 'Bearer ' . 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NTA5MTA0OTAsImV4cCI6MTY1MDkxNDA5MCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sImVtYWlsIjoiZ2hpbGFyZGlsb2dhbkBnbWFpbC5jb20ifQ.XDjmkkL4Ac-Vdu-4cYJ6gsfK9b7UFAcBXtJBocI6olzJCFwg--_zDjkk-saE3mPmDVdD4GsCXwBDNTUVrlof8PeasV3qDbKvsrPUeLicbbfwbMeLBmWKHzOJLybUuSFzCKPvgMc8RjM1d8e193mA-S9dYJw-ksvQopeaYiTOrIU1VnFsN2fE8ldHc02eDI8h6zLcZ12EbqYl6p8aLdpv6tpzlqKcviym-lGh9EnHmfAMC_vwBcckfQoq7ZZmQt55qhTZNeHoPgwxMWo-mpo0pigki1injZtPwRByB5O_RVfwj5eAG2oPJgrZR7kA7h1rSaipyDo3AfvKGTFyyKPusB3tXTjxepILrt0Arj8UANVZyv9yzSjy-gqtExB9EpVBjZRTKdpucS_mW-7pMMyLKYt73fSKQ3jMoeaoG6lrs8sqiZeR9lxejkGelTNUBD86WfAcFqWvMmWIZasF1_pG9CJq9y47g7OEZrCMfRn2gJCZTPEix4t5uR34-byEZMxYNOlZeEPUyX6IF33i3LU9_4D5H6B6Alx5M_8QwC3Qt1nSoZ_qKisrZrlLH_KfIG5UlKZQqlh3Vc21P4KhKY0EFL63_XqKF9q_vXgBQ7dK6fIIVz--NtX884esYdvdAcqG_NhiPvDYmoe2Qs-PgxrYTriWzndgKDZ_IFWAl4TrFtw',
            'Accept' => 'application/json',
        ];
        $response = $this->client->request(
            'GET',
            'http://127.0.0.1:8001/api/users',
            ['headers' => $header]
        );

        return $response->toArray();
    }
}