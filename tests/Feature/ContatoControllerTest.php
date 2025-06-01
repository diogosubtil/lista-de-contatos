<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContatoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_contato_com_sucesso()
    {
        $user = User::factory()->create();

        $payload = [
            "nome" => "Cliente 2",
            "cpf" => "530.268.000-90",
            "telefone" => "419999999",
            "cep" => "83045100",
            "rua" => "Rua Francisco Toczek",
            "numero" => "591",
            "bairro" => "Afonso Pena",
            "cidade" => "SPJ",
            "estado" => "PR"
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/contatos/cadastro', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Contato criado com sucesso.',
                'data' => [
                    "nome" => "Cliente 2",
                    "cpf" => "530.268.000-90",
                    "telefone" => "419999999",
                    "cep" => "83045100",
                    "rua" => "Rua Francisco Toczek",
                    "numero" => "591",
                    "bairro" => "Afonso Pena",
                    "cidade" => "SPJ",
                    "estado" => "PR"
                ]
            ]);
    }

    public function test_criar_contato_com_cpf_duplicado()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum')->postJson('/api/contatos/cadastro', [
            "nome" => "Cliente 2",
            "cpf" => "530.268.000-90",
            "telefone" => "419999999",
            "cep" => "83045100",
            "rua" => "Rua Francisco Toczek",
            "numero" => "591",
            "bairro" => "Afonso Pena",
            "cidade" => "SPJ",
            "estado" => "PR"
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/contatos/cadastro', [
            "nome" => "Cliente 2",
            "cpf" => "530.268.000-90",
            "telefone" => "419999999",
            "cep" => "83045100",
            "rua" => "Rua Francisco Toczek",
            "numero" => "591",
            "bairro" => "Afonso Pena",
            "cidade" => "SPJ",
            "estado" => "PR"
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => false,
                'message' => 'CPF ja cadastrado na sua lista de contatos.'
            ]);
    }
}
