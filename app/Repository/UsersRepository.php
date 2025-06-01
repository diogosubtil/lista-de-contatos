<?php

namespace App\Repository;

use App\Models\User;

class UsersRepository
{
    public function __construct(User $user){
        $this->model = $user;
    }

    /**
     * Cria um novo usuário com os dados fornecidos, incluindo a criptografia da senha.
     *
     * @param  array  $dados
     *
     */
    public function create($dados)
    {
        return $this->model->create($dados);
    }

    /**
     * Remove um usuário com base no ID.
     *
     * @param  int  $id
     *
     */
    public function destroy($id)
    {
        return $this->model->destroy($id);
    }


    /**
     * Busca o usuário com base no ID.
     *
     * @param  int  $id
     *
     */
    public function find($id)
    {
        return $this->model->find($id);
    }
}
