<?php


namespace App\Services\Remonline\Models;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class Base
{
    protected const BASE_URL = 'https://api.remonline.ru/';

    public $http;

    protected $token;
    protected $api_key;

    public function init(string $api_key): Base
    {
        $this->api_key = $api_key;
        $this->http    = new Client();

        $this->checkAccess();

        return $this;
    }

    private function checkAccess()
    {
        $response = Http::withHeaders($this->getHeaders())
            ->get($this::BASE_URL.'token/new?api_key='.$this->api_key);

        if($response->json()['success']) {

            $this->token = $response->json()['token'];
        }
    }

    protected function getBaseQuery() : array
    {
        return ['token' => $this->token];
    }

    protected function getHeaders(): array
    {
        return [
            'accept' => 'application/json',
        ];
    }

    public function __call($name, $arguments)
    {
        $modelName = __NAMESPACE__.'\\'.ucfirst($name);

        return $this->$name = new $modelName($this->token);
    }
}
