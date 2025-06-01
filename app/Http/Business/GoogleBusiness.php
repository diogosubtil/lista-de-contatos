<?php

namespace App\Http\Business;

use App\Http\Requests\UsersFormRequest;
use App\Repository\GoogleRepository;

class GoogleBusiness
{
    private $repository;

    public function __construct(GoogleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($dados)
    {
        $dados['latitude'] = $dados['lat'];
        $dados['longitude'] = $dados['lng'];
        return $this->repository->create($dados);
    }

    public function update($dados)
    {
        $dados['latitude'] = $dados['lat'];
        $dados['longitude'] = $dados['lng'];
        return $this->repository->update($dados);
    }
}
