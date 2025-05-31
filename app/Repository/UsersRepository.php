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
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($dados){
        $dados['password'] = bcrypt($dados['password']);
        return $this->model->create($dados);
    }

    /**
     * Remove um usuário com base no ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|int
     *
     */
    public function destroy($id)
    {
        try {
            $user = $this->model->find($id);
            if (!$user) {
                throw new \Exception('Usuário não encontrado');
            }
            return $this->model->destroy($id);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
