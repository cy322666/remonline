<?php

namespace App\Services\Remonline\Models;

use Illuminate\Support\Facades\Http;

class Clients extends Base
{
    const URL = 'clients/';

    protected $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function search(array $params)
    {
        $response = Http::withHeaders($this->getHeaders())
            ->get($this::BASE_URL.self::URL, ['token' => $this->token] + $params);

        return $response->json()['count'] == 0 ? null : $response->json()['data'][0];
    }

    public function create(array $params)
    {
        $response = Http::withHeaders($this->getHeaders())
            ->post($this::BASE_URL.self::URL, ['token' => $this->token] + $params);

        return $response->json()['data'];
    }
}
