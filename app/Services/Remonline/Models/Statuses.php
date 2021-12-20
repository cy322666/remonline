<?php

namespace App\Services\Remonline\Models;

use Illuminate\Support\Facades\Http;

class Statuses extends Base
{
    const URL = 'statuses';

    public function all()
    {
        $response = Http::withHeaders($this->getHeaders())->get($this::BASE_URL.self::URL);

        return $response->json();
    }
}
