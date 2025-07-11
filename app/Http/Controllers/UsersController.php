<?php

namespace App\Http\Controllers;

use App\Http\Business\UsersBusiness;
use App\Http\Requests\DeleteAccountRequest;
use App\Http\Requests\UsersFormRequest;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    private $business;

    public function __construct(UsersBusiness $business)
    {
        $this->business = $business;
    }

    /**
     * Cria um novo usuário no sistema.
     *
     * @param  \App\Http\Requests\UsersFormRequest  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Usuário criado com sucesso.",
     *   "data": {
     *     "id": 1,
     *     "name": "João Silva",
     *     "email": "joao@example.com",
     *     ...
     *   }
     * }
     *
     * @response 500 {
     *   "success": false,
     *   "message": "Erro ao criar usuário.",
     *   "error": "Mensagem de erro detalhada"
     * }
     */
    public function store(UsersFormRequest $request)
    {
        try {
            $user = $this->business->create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Usuário criado com sucesso.',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar usuário: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar usuário.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove a conta do usuário autenticado após confirmar a senha.
     *
     * @param  \App\Http\Requests\DeleteAccountRequest  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @authenticated
     *
     * @response 200 {
     *     "success": true,
     *     "message": "Conta excluída com sucesso."
     * }
     *
     * @response 422 {
     *     "message": "A senha informada está incorreta.",
     *     "errors": {
     *         "password": ["A senha informada está incorreta."]
     *     }
     * }
     */
    public function deleteAccount(DeleteAccountRequest $request)
    {
        try {
            $this->business->destroy($request);

            return response()->json([
                'success' => true,
                'message' => 'Conta excluída com sucesso.',
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao excluir conta: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir a conta.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
