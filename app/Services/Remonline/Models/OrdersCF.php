<?php

namespace App\Services\Remonline\Models;

use Illuminate\Support\Facades\Http;

class OrdersCF extends Base
{
    const URL = 'order/custom-fields/';

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function all()
    {
        $response = Http::withHeaders($this->getHeaders())
            ->get($this::BASE_URL.self::URL, ['token' => $this->token]);

        return $response->json()['data'] ?? null;
    }
}
