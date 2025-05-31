<?php

namespace App\Http\Controllers;

use App\Http\Requests\CepRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CepController extends Controller
{

    /**
     * Consulta informações de endereço a partir de um CEP válido utilizando a API ViaCEP.
     *
     * @param  \App\Http\Requests\CepRequest  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     *     "cep": "01001-000",
     *     "logradouro": "Praça da Sé",
     *     "complemento": "lado ímpar",
     *     "bairro": "Sé",
     *     "localidade": "São Paulo",
     *     "uf": "SP",
     *     "ibge": "3550308",
     *     "gia": "1004",
     *     "ddd": "11",
     *     "siafi": "7107"
     * }
     *
     * @response 404 {
     *     "erro": "CEP não encontrado"
     * }
     */
    public function get(CepRequest $request)
    {
        $cep = $request->input('cep');

        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        if ($response->failed() || isset($response['erro'])) {
            return response()->json(['erro' => 'CEP não encontrado'], 404);
        }

        return response()->json($response->json());
    }
}
