<?php

namespace App\Services\Google;

use GuzzleHttp\Client;

abstract class GoogleApi
{

    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config("google.google_host")
        ]);
    }

    protected function getKey(): string
    {
        return config("google.api_key");
    }
}
