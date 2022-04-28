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
            'Authorization' =>
                'Bearer ' .
                'eyJ0eXAiOiJKV1QiLCJhbGciOiJSzI1NiJ9.eyJpYXQiOjE2NTA5MTUzMzIsImV4cCI6MTY1MDkxODkzMiwicm9sZXMiOlsiUk9MRV9VU0VSIl0sImVtYWlsIjoiZ2hpbGFyZGlsb2dhbkBnbWFpbC5jb20ifQ.VWq2c7duqUkc5h1r47_4iejQ5Kdn17ocnOOitVcj3dCP_8hU_NzhihNBjRUeopQwIYPfcDgb3U7Hpty-ZxYQr7PmW9GD8DfsKQt86VwlTyuKOgGqGpnLs0ZyxlKJTuBWNOGoVn9dO4mpAiesPo4pCXjvPiKb06206hAiteKCPwaHtTY7F-RWXn1DIKSvTnsbM7oCL260h8lBK4usza-dNj-9QVbf7Mnfhvd_FYsiJPhg2-EcaIsYTEonbKhKE5FQ-k8qbKpXxuJdc7uK-tzVNLjlI8eZ2QRCF339mu5k79WYZqSvexsn1mDnTSaKHAwbMMoIdajt-tj8JAo4GiUtlCE21n9dIZDYm4dsl-s0l7lhYaspjawuK9Yyk_aXrxnFRtKnT_14ug7a_P_smppQTKsiqe9DU59wxO_5PBluFOKKT5B3uX0nMHmYujHM2oAOApelR6Ivg1ZbOhGdFOd0QO9KRNQT-ipoFMU8Voh1MGajZIIzgjWa4brMbOkN9CZDSbpWkNTf8AYe4OKPQ3iZK1wQkjUHBawg6bhKHtuO4_GGQy0vpAIoaJ0f0LUvIMT0EFzDStiPYcnsHYvifPS9h8nT7EGVQUkEuXvDp1ISQM0cvTVjVFeA1VonSiVwtU04sWqxsIHRM4-TDw2vzX2pJrFkPVhI5bsDI0UAzwx_bTc',
            'Accept' => 'application/json',
        ];
        try {
            $response = $this->client->request(
                'GET',
                'http://127.0.0.1:8000/api/users',
                ['headers' => $header]
            );

            return $response->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }
}
