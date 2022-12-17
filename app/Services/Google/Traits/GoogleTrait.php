<?php

namespace App\Services\Google\Traits;

use Exception;

trait GoogleTrait
{
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    private function getParams(): array
    {
        if(!is_array($this->params)){
            throw new Exception("Params need to be a array");
        }

        return $this->params;
    }

    public function getResponse($associative = false)
    {
        return json_decode($this->response, $associative);
    }
}
