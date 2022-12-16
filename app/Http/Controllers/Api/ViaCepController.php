<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Exception;

class ViaCepController extends Controller
{
    
    /**
     * Consulta o cep na base do via cep
     *
     * @param string $cep
     * @return JsonResponse
     */
    public function __invoke(string $cep): JsonResponse
    {

        try {

            if(strlen($cep) > 8){
                throw new Exception("O tamanho do cep informado não condiz com o esperado de 8 caracteres");
            }

            $response = Http::get("https://viacep.com.br/ws/{$cep}/json");
        
            if($response->status() != 200){
                throw new Exception("Não foi possivel localizar o cep {$cep}");
            }

            return response()->json([
                "type" => "success",
                "message" => "Sucesso ao buscar cep",
                "data" => $response->json()
            ],200);
            
        } catch (Exception  $ex) {

            return response()->json([
                "type" => "error",
                "message" => $ex->getMessage(),
                "data" => []
            ], 400);

        }
        
    }

}
