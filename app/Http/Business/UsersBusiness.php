<?php

namespace App\Http\Business;

use App\Repository\UsersRepository;
use Illuminate\Support\Facades\Log;

class UsersBusiness
{
    private $repository;

    public function __construct(usersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($dados)
    {
        $dados['password'] = bcrypt($dados['password']);
        return $this->repository->create($dados);
    }

    public function destroy($request)
    {
        $user = $request->user();

        Log::info("Conta excluída para o usuário ID {$user->id}");

        $user = $this->repository->find($user->id);

        if (!$user) {
            throw new \Exception('Usuário não encontrado');
        }

        $request->user()->currentAccessToken()->delete();

        return $this->repository->destroy($user->id);
    }
}
