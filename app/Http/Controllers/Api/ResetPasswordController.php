<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Exception;

class ResetPasswordController extends Controller
{
    
    /**
     * Envia email contendo o link para recuperar a senha
     *
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            
            $status = Password::sendResetLink($request->only('email'));

            if($status === Password::RESET_LINK_SENT){
                return response()->json([
                    "type" => "success",
                    "message" =>__($status)
                ]);
            }

            throw new Exception(__($status));

        } catch (Exception $ex) {
            return response()->json([
                "type" => "error",
                "message" => $ex->getMessage()
            ],404);
        }
    }

    /**
     * Valida o token enviado para poder alterar a senha do usuario
     *
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        try {
            $status = Password::reset(
                $request->except("password_confirmation"),
                function($user, $password){
                    $user->forceFill([
                        "password" => bcrypt($password)
                    ]);

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            if($status === Password::PASSWORD_RESET){
                return response()->json([
                    "type" => "success",
                    "mesasge" => __($status)
                ],200);
            }

            throw new Exception(__($status));

        } catch (Exception $ex) {
            return response()->json([
                "type" => "error",
                "mesasge" => $ex->getMessage()
            ],400);
        }
    }

}
