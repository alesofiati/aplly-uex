<?php

namespace App\Services\Google;

use App\Services\Google\Traits\GoogleTrait;

class GoogleMapsService extends GoogleApi {

    use GoogleTrait;

    private array $params;
    protected $response;

    public function geocoding(): void
    {
        $this->response = $this->client->request("GET", "maps/api/geocode/json", [
            "query" => array_merge($this->prepareParams(), [
                "key" => $this->getKey()
            ])
        ])->getBody()->getContents();
    }

    public function getLocation()
    {
        return array_column($this->getResponse()->results, "geometry")[0];
    }


}