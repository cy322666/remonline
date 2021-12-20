<?php

namespace App\Services\Remonline\Models;

use Illuminate\Support\Facades\Http;

class Invoices extends Base
{
    const URL = 'invoices/';

    public function all()
    {dd($this->getBaseQuery());
        $response = Http::withHeaders($this->getHeaders())->get($this::BASE_URL.self::URL.$this->getBaseQuery());

        return $response->json();
    }
}
