<?php

namespace App\Http\Controllers;

use App\Http\Business\ContatosBusiness;
use App\Http\Requests\ContatoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContatosController extends Controller
{

    private $business;

    public function __construct(ContatosBusiness $business)
    {
        $this->business = $business;
    }

    /**
     * Retorna a lista de registros, ou uma mensagem caso esteja vazia.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 [
     *   { "id": 1, "nome": "Contato A", ... },
     *   { "id": 2, "nome": "Contato B", ... }
     * ]
     *
     * @response 204 {
     *   "message": "Nenhum dado encontrado."
     * }
     */
    public function list(Request $request)
    {
        try {
            $dados = $this->business->list($request);

            if ($dados->isEmpty()) {
                return response()->json(['message' => 'Nenhum dado encontrado.']);
            }

            return response()->json($dados);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar contatos.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(ContatoRequest $request)
    {
        try {
            $contato = $this->business->create($request->all());

            if (!empty($contato['erro_cpf'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'CPF ja cadastrado na sua lista de contatos.',
                    'data' => $contato['erro_cpf']
                ], 201);
            }

            return response()->json([
                'success' => true,
                'message' => 'Contato criado com sucesso.',
                'data' => $contato
            ], 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar contato: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar contato.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(ContatoRequest $request)
    {
        try {
            $contato = $this->business->update($request->all());

            if (!empty($contato['erro_id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Contato não encontrado.',
                ]);
            }

            if (!empty($contato['erro_cpf'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'CPF ja cadastrado na sua lista de contatos.',
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Contato atualizado com sucesso.',
                'data' => $contato
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar contato: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar contato.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $contato = $this->business->destroy($request->all());

            if (!empty($contato['erro_id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Contato não encontrado.',
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Contato excluido com sucesso.',
            ], 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar contato: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar contato.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
