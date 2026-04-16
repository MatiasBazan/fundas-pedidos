<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stock_id'      => ['required', 'integer', 'exists:stocks,id'],
            'nombre'        => ['required', 'string', 'max:255'],
            'apellido'      => ['required', 'string', 'max:255'],
            'precio'        => ['required', 'numeric', 'min:0'],
            'estado_pedido' => ['required', 'in:disponible,entregado'],
            'estado_pago'   => ['required', 'in:no_pagado,pagado'],
            'tipo_pago'     => [$this->input('estado_pago') === 'pagado' ? 'required' : 'nullable', 'in:efectivo,transferencia'],
        ];
    }

    public function messages(): array
    {
        return [
            'stock_id.required' => 'Debe seleccionar un producto del stock.',
            'stock_id.exists'   => 'El producto seleccionado no existe.',
            'nombre.required'   => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'precio.required'   => 'El precio es obligatorio.',
            'precio.numeric'    => 'El precio debe ser un número.',
            'precio.min'        => 'El precio debe ser mayor o igual a 0.',
            'tipo_pago.required' => 'El tipo de pago es obligatorio cuando el estado es pagado.',
        ];
    }
}
