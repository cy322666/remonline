<?php

namespace App\Services\Remonline\Models;

use Illuminate\Support\Facades\Http;

class Orders extends Base
{
    const URL = 'order/';

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function create(array $params)
    {//dd(json_encode($params));
        $response = Http::withHeaders($this->getHeaders())
            ->post($this::BASE_URL.self::URL, ['token' => $this->token] + $params);

        return $response->json()['data'];
    }
}
