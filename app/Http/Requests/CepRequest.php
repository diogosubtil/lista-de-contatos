<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CepRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cep' => ['required', 'regex:/^\d{8}$/']
        ];
    }

    public function messages(): array
    {
        return [
            'cep.required' => 'O CEP é obrigatório.',
            'cep.regex' => 'O CEP deve conter exatamente 8 dígitos numéricos.',
        ];
    }
}
