<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'El correo es obligatorio',
            'email.email' => 'El correo no es valido'
        ];
    }
}
