<?php

namespace App\Services\Remonline;

use App\Services\Remonline\Models\Base;
use App\Services\Remonline\Models\Invoices;

class Client
{
    public Base $service;

    public function __construct(string $api_key)
    {
        $this->service = (new Base())->init($api_key);
    }
}
