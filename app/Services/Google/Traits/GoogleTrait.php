<?php

namespace App\Services\Google\Traits;

use Exception;

trait GoogleTrait
{

    /**
     * Informa os dados que serão utilizados na api
     *
     * @param array $params
     * 
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * Recuperar os dados informados para API
     *
     * @return array
     */
    protected function getParams(): array
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

    /**
     * Preapara os dados para serem enviados para api. 
     * Caso alguma das chaves do array seja um outro array ele converte tudo para exibir em uma string
     *
     * @return array
     */
    private function prepareParams(): array
    {

        if(!isset($this->params['address'])){
            throw new Exception("Informe o address");
        }

        $params = $this->getParams();
        foreach($params as $key => $value){
            if(is_array($value)){
                $params[$key] = implode(",", $value);
            }
        }
        
        return $params;
    }
}
