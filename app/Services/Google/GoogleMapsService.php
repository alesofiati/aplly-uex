<?php

namespace App\Services\Google;

use App\Services\Google\Traits\GoogleTrait;
use Exception;

class GoogleMapsService extends GoogleApi {

    use GoogleTrait;

    private array $params;
    protected $response;

    public function geocoding(): void
    {
        $this->response = $this->client->request("GET", "maps/api/geocode/json", [
            "query" => [
                "address" => $this->getAddress(),
                "key" => $this->getKey()
            ]
        ])->getBody()->getContents();
    }

    private function getAddress(): string
    {
        if(!array_key_exists("address", $this->getParams())){
            throw new Exception("Key address not found");
        }
        return implode(",", $this->params['address']);
    }


}