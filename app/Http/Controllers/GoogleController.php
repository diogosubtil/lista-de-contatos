<?php

namespace App\Http\Controllers;

use App\Http\Business\GoogleBusiness;
use App\Http\Requests\CepRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{

    private $business;

    public function __construct(GoogleBusiness $business)
    {
        $this->business = $business;
    }

    /**
     * Consulta coordenadas geográficas reais a partir de um endereço completo
     * usando a API do Google Maps.
     *
     * @param array $dados Array contendo os campos: rua, numero, bairro, cidade, estado, cep
     * @return array|null Retorna um array com 'lat' e 'lng' ou null se não encontrar
     *
     * @example
     * $dados = [
     *     'rua' => 'Rua A',
     *     'numero' => '123',
     *     'bairro' => 'Centro',
     *     'cidade' => 'São Paulo',
     *     'estado' => 'SP',
     *     'cep' => '01001000'
     * ];
     *
     * @return [
     *     "lat" => -23.55052,
     *     "lng" => -46.633308
     * ]
     */
    function get($dados)
    {
        $endereco = "{$dados['rua']}, {$dados['numero']}, {$dados['bairro']}, {$dados['cidade']}, {$dados['estado']}, {$dados['cep']}";

        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $endereco,
            'key' => env('GOOGLE_MAPS_API_KEY'),
        ]);

        $json = $response->json();

        if (
            $response->failed() ||
            empty($json['results']) ||
            !isset($json['results'][0]['geometry']['location'])
        ) {
            return null;
        }

        return [
            'lat' => $json['results'][0]['geometry']['location']['lat'],
            'lng' => $json['results'][0]['geometry']['location']['lng'],
        ];
    }

    /**
     * Armazena as coordenadas geográficas no banco de dados
     * associando-as a um contato.
     *
     * @param array $dados Array contendo 'contato_id', 'latitude', 'longitude'
     * @return \App\Models\Google O modelo criado no banco
     *
     * @example
     * $dados = [
     *     'contato_id' => 1,
     *     'latitude' => -25.4381,
     *     'longitude' => -49.2692
     * ];
     */
    public function store($dados)
    {
        return $this->business->create($dados);
    }

    /**
     * Atualiza as coordenadas geográficas associadas a um contato.
     *
     * @param array $dados Array contendo 'contato_id', 'latitude', 'longitude'
     * @return \App\Models\Google|null O modelo atualizado ou null se não encontrado
     *
     * @example
     * $dados = [
     *     'contato_id' => 1,
     *     'latitude' => -25.4300,
     *     'longitude' => -49.2700
     * ];
     */
    public function update($dados)
    {
        return $this->business->update($dados);
    }
}
