<?php

namespace App\Http\Business;

use App\Http\Controllers\CepController;
use App\Http\Controllers\GoogleController;
use App\Repository\ContatosRepository;
use Illuminate\Support\Facades\Auth;

class ContatosBusiness
{
    private $repository;
    private $cep;
    private $google;

    public function __construct(ContatosRepository $repository, CepController $cep, GoogleController $google)
    {
        $this->repository = $repository;
        $this->cep = $cep;
        $this->google = $google;
    }

    public function list($request)
    {
        $user = $request->user();
        return $this->repository->list($request, $user);
    }


    public function create($dados)
    {
        $user = Auth::user();
        $dados['user_id'] = $user->id;

        // Verifica se o CPF já existe para este usuário
        if (!empty($this->repository->find($dados['cpf'], $user->id))) {
            return ['erro_cpf' => 'Este CPF já está vinculado a outro contato.'];
        }

        // Obtém coordenadas via Google
        $google = $this->google->get($dados);

        // Cria o contato
        $contato = $this->repository->create($dados);

        // Se coordenadas foram encontradas, armazena na tabela google
        $google['contato_id'] = $contato->id;
        if (!empty($google)) {
            $this->google->store($google);
        }

        return $contato;
    }

    public function update($dados)
    {
        $user = Auth::user();
        $dados['user_id'] = $user->id;

        // Verifica se o usuario existe.
        if (empty($this->repository->findContato($dados['id']))) {
            return ['erro_id' => true];
        }

        // Verifica se o CPF já existe para este usuário
        if (!empty($this->repository->findUpdate($dados['id'], $dados['cpf'], $user->id))) {
            return ['erro_cpf' => true];
        }

        // Obtém coordenadas via Google
        $google = $this->google->get($dados);

        // Atualiza o contato
        $contato = $this->repository->update($dados);

        // Se coordenadas foram encontradas e o contato existir, atualiza na tabela google
        $google['contato_id'] = $contato->id;
        if (!empty($google) && !empty($contato)) {
            $this->google->update($google);
        }

        return $contato;
    }

    public function destroy($dados)
    {
        // Verifica se o usuario existe.
        if (empty($this->repository->findContato($dados['id']))) {
            return ['erro_id' => true];
        }

        // Exclui o contato
        return $this->repository->destroy($dados);
    }
}
