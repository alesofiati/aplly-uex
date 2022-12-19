<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ViaCepController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('endereco/{cep}/cep', ViaCepController::class)
        ->name('endereco.cep')->where('cep', '[0-9]+');

    Route::prefix("user")->group(function(){
        Route::delete("delete", [UserController::class, "destroy"]);
        Route::get("contatos", [UserController::class, "index"]);
        Route::post("contato/create", [UserController::class, "contatoStore"]);
        Route::post("contato/{contatoId}", [UserController::class, "contatoUpdate"]);
        Route::delete("contato/{contatoId}", [UserController::class, "contatoDestroy"]);
    });
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', AuthController::class);
Route::post('forgot-password', [ResetPasswordController::class, "forgotPassword"]);
Route::post('reset-password', [ResetPasswordController::class, "resetPassword"]);
