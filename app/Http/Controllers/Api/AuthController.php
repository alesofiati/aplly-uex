<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Error;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Efetua autenticação do usuario
     *
     * @param AuthenticationRequest $request
     * @return JsonResponse
     */
    public function __invoke(AuthenticationRequest $request): JsonResponse
    {
        try {
            $user = User::where('email', $request->email)->firstOrFail();

            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'type' => 'success',
                    'message' => 'user logged success',
                    'data' => [
                        'user' => $user,
                        'token' => $user->createToken($user->id)->plainTextToken
                    ]
                ]);
            }

            throw new Error("These credentials do not match our records", 1);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'type' => 'error',
                'message' => 'These credentials do not match our records',
            ], 400);
        } catch(Error $error) {
            return response()->json([
                'type' => 'error',
                'message' => $error->getMessage(),
            ], 400);
        }
    }

    /**
     * Revoga todos os tokens do usuario logado
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'type' => 'success',
            'message' => 'User success logout.',
        ], 200);
    }
}
