<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Realiza o login do usuário com e-mail e senha.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     *     "mensagem": "Acesso autenticado",
     *     "token": "eyJ0eXAiOiJKV1QiLCJh..."
     * }
     *
     * @response 401 {
     *     "message": "Credenciais inválidas"
     * }
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        $user = $request->user();

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'mensagem' => 'Acesso autenticado',
            'token' => $token,
        ]);
    }

    /**
     * Realiza o logout do usuário revogando o token atual.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     *     "mensagem": "Logout realizado com sucesso."
     * }
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['mensagem' => 'Logout realizado com sucesso.']);
    }
}

