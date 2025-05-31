<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CepController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/usuario/cadastro', [UsersController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/esqueceu', [ForgotPasswordController::class, 'sendResetLinkEmail']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::delete('/usuario/deletar', [UsersController::class, 'deleteAccount']);

    Route::get('/cep', [CepController::class, 'get']);
});

