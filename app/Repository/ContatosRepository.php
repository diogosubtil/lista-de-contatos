<?php

namespace App\Repository;

use App\Models\Contato;

class ContatosRepository
{
    private $model;

    public function __construct(Contato $model) {
        $this->model = $model;
    }

    public function list($request, $user)
    {
        $query = $this->model->query()
            ->with('coordenadas')
            ->where('user_id', $user->id);

        // Filtro por nome
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        // Filtro por CPF
        if ($request->filled('cpf')) {
            $query->where('cpf', $request->cpf);
        }

        // Ordenação
        $sortBy = $request->get('sort_by', 'nome');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginação
        $perPage = $request->get('per_page', 10);
        if ($perPage) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    public function create($dados)
    {
        return $this->model->create($dados);
    }

    public function find($cpf, $user_id)
    {
        return $this->model->query()
            ->where('cpf', $cpf)
            ->where('user_id', $user_id)
            ->first();
    }

    public function findContato($id)
    {
        return $this->model->find($id);
    }

    public function findUpdate($contato_id, $cpf, $user_id)
    {
        return $this->model->query()
            ->where('id','!=', $contato_id)
            ->where('cpf', $cpf)
            ->where('user_id', $user_id)
            ->first();
    }

    public function update($dados)
    {
        $contato = $this->model->find($dados['id']);

        if (!$contato) {
            return null;
        }

        $contato->update($dados);

        return $contato->fresh();
    }

    public function destroy($dados)
    {
        $contato = $this->model->find($dados['id']);
        return $contato->delete();
    }
}
