<?php

namespace App\Repository;

use App\Models\Google;

class GoogleRepository
{
    private $model;

    public function __construct(Google $model)
    {
        $this->model = $model;
    }

    public function create($dados)
    {
        return $this->model->create($dados);
    }

    public function update($dados)
    {
        $coordenada = $this->model->query()
            ->where('contato_id', $dados['contato_id'])
            ->first();

        if (!$coordenada) {
            return null;
        }

        $coordenada->update($dados);

        return $coordenada->fresh();
    }

}
