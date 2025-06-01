<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela de contatos com endereço separado.
     */
    public function up(): void
    {
        Schema::create('contatos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nome');
            $table->string('cpf', 14);
            $table->string('telefone');
            $table->string('cep', 9);
            $table->string('rua');
            $table->string('numero');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado', 2);
            $table->string('complemento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Remove a tabela de contatos.
     */
    public function down(): void
    {
        Schema::dropIfExists('contatos');
    }
};
