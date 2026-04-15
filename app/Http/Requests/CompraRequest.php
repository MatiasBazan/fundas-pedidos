<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'modelo_celular'  => ['required', 'string', 'max:255'],
            'nombre_disenio'  => ['required', 'string', 'max:255'],
            'cantidad'        => ['required', 'integer', 'min:1'],
            'precio_unitario' => ['required', 'numeric', 'min:0'],
            'observaciones'   => ['nullable', 'string', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'modelo_celular'  => 'modelo de celular',
            'nombre_disenio'  => 'nombre de diseño',
            'cantidad'        => 'cantidad',
            'precio_unitario' => 'precio unitario',
            'observaciones'   => 'observaciones',
        ];
    }
}
