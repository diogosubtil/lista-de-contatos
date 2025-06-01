<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Google extends Model
{
    use HasFactory;

    protected $table = 'google';

    protected $fillable = [
        'contato_id',
        'latitude',
        'longitude',
    ];

    /**
     * Retorna o contato relacionado às coordenadas.
     */
    public function contato()
    {
        return $this->belongsTo(Contato::class, 'contato_id');
    }
}
