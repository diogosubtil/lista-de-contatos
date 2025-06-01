<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    use HasFactory;

    protected $table = 'contatos';

    protected $fillable = [
        'user_id',
        'nome',
        'cpf',
        'telefone',
        'cep',
        'rua',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'complemento',
    ];

    /**
     * Retorna as coordenadas geográficas associadas ao contato.
     */
    public function coordenadas()
    {
        return $this->hasOne(Google::class, 'contato_id');
    }

}
