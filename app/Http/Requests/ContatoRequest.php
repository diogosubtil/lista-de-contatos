<?php

namespace App\Http\Requests;

use App\Rules\CpfValido;
use Illuminate\Foundation\Http\FormRequest;

class ContatoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'          => ['required', 'string', 'max:255'],
            'cpf'           => ['required', 'string', 'size:14', new CpfValido()],
            'telefone'      => ['required', 'string', 'max:20'],
            'cep'           => ['required', 'string', 'size:8'],
            'rua'           => ['required', 'string', 'max:255'],
            'numero'        => ['required', 'string', 'max:20'],
            'bairro'        => ['required', 'string', 'max:100'],
            'cidade'        => ['required', 'string', 'max:100'],
            'estado'        => ['required', 'string', 'size:2'],
            'complemento'   => ['string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.size'     => 'O CPF deve conter 14 caracteres no formato 000.000.000-00.',
            'cep.size'     => 'O CEP deve conter exatamente 8 dígitos.',
            'estado.size'  => 'O estado deve conter 2 letras (ex: SP, RJ).',
        ];
    }
}
