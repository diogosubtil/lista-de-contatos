<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{

    /**
     * Envia um e-mail com o link de redefinição de senha para o usuário informado.
     *
     * @param  \App\Http\Requests\ForgotPasswordRequest  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     *     "mensagem": "Link de redefinição enviado para o e-mail."
     * }
     *
     * @response 500 {
     *     "mensagem": "Não foi possível enviar o e-mail."
     * }
     */
    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['mensagem' => 'Link de redefinição enviado para o e-mail.']);
        }

        return response()->json(['mensagem' => 'Não foi possível enviar o e-mail.'], 500);
    }
}
