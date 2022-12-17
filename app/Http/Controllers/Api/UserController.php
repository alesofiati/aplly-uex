<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    
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
}
