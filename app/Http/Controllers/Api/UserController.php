<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserContatctRequest;
use Illuminate\Http\JsonResponse;
use App\Models\UserContact as Contato;
use App\Services\ContatoService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Services\Google\GoogleMapsService;

class UserController extends Controller
{

    /**
     * Retorna uma lista de contatos baseadas nos filtros aplicacos
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {

        $perPage = $request->perPage ?? 5;
        $orderBy = $request->orderBy ?? "asc";

        $contatos = Contato::query();

        if(isset($request->name) || isset($request->document_number) ){
            $fields = $request->only(["name", "document_number"]);
            $contatos->where(function($query) use($fields){
                if(isset($fields["name"])){
                    $query->orWhere("name", "like", "%{$fields['name']}%");
                }
                if(isset($fields["document_number"])){
                    $query->orWhere("document_number", "like", "%{$fields['document_number']}%");
                }
            });
        }

        $contatos->orderBy("name", $orderBy);

        return response()->json(
            $contatos->paginate($perPage), 200);
    }
    
    public function contatoStore(UserContatctRequest $request, ContatoService $contatoService): JsonResponse
    {

        $requestValidated = $request->validated();

        $location = $this->getLocation($request);

        $contato = auth()->user()->contacts()->create([
            ...$requestValidated,
            ...$location
        ]);

        if(is_null($contato)){
            return response()->json([
                "type" => "error",
                "message" => "Não foi possivel criar o contato",
            ], 400);
        }

        return response()->json([
            "type" => "sucess",
            "message" => "Contato criado com sucesso",
            "data" => $contato
        ], 201);
    }

    /**
     * Atualizando um contato com base no contatoId informado
     *
     * @param int $contatoId
     * @param UserContatctRequest $request
     * @return JsonResponse
     */
    public function contatoUpdate(int $contatoId, UserContatctRequest $request):JsonResponse
    {
        try {

            $requestValidated = $request->validated();
            $location = $this->getLocation($request);

            $contato = Contato::where("id", $contatoId)->firstOrFail();
            $contato->update([
                ...$requestValidated,
                ...$location
            ]);

            return response()->json([
                "type" => "success",
                "message" => "Contato atualizado com sucesso",
                "data" => [
                    "contato" => Contato::where("id", $contatoId)->first()
                ]
            ]);

        } catch (ModelNotFoundException $ex) {
            return response()->json([
                "type" => "error",
                "message" => "O contato informado não foi localizado"
            ],404);
        }
    }

    public function contatoDestroy(int $contatoId): JsonResponse
    {
        try {
            $contato = Contato::where("id", $contatoId)->firstOrFail();
            $contato->delete();

            return response()->json([
                "type" => "success",
                "message" => "Contato removido com sucesso"
            ],200);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                "type" => "error",
                "message" => "Não foi possivel remover o contato"
            ],404);
        }
    }

    /**
     * Remove o usuario logado e todos os seus registros
     *
     * @return JsonResponse
     */
    public function destroy(): JsonResponse
    {
        $user = auth()->user();

        $user->tokens()->delete();

        $user->delete();

        return response()->json([
            "type" => "success",
            "message" => "O usúario foi removido com sucesso"
        ]);

    }

    /**
     * Recupera atraves da api do google os dados de localização
     *
     * @param Request $request
     * @return array
     */
    private function getLocation(Request $request): array
    {

        $address = $request->only([
            "street","street_number","neighborhood","city","state",
        ]);

        $googleMaps = new GoogleMapsService();

        $googleMaps->setParams(["address" => $address])->geocoding();

        $geoLoation = $googleMaps->getLocation();

        return [
            "latitude"  => $geoLoation->location->lat,
            "longitude" => $geoLoation->location->lng
        ];
    }
}
