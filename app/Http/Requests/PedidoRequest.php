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
            'nombre_disenio'  => 'required|string|max:255',
            'modelo_celular'  => 'required|string|max:255',
            'nombre'          => 'required|string|max:255',
            'apellido'        => 'required|string|max:255',
            'precio'          => 'required|numeric|min:0',
            'estado_pedido'   => 'required|in:disponible,entregado',
            'estado_pago'     => 'required|in:pagado,no_pagado',
            'tipo_pago'       => 'required_if:estado_pago,pagado|nullable|in:efectivo,transferencia',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_disenio.required'  => 'El nombre del diseño es obligatorio.',
            'modelo_celular.required'  => 'El modelo de celular es obligatorio.',
            'nombre.required'          => 'El nombre es obligatorio.',
            'apellido.required'        => 'El apellido es obligatorio.',
            'precio.required'          => 'El precio es obligatorio.',
            'precio.numeric'           => 'El precio debe ser un número.',
            'precio.min'               => 'El precio debe ser mayor a 0.',
            'estado_pedido.required'   => 'El estado del pedido es obligatorio.',
            'estado_pago.required'     => 'El estado de pago es obligatorio.',
            'tipo_pago.required_if'    => 'El tipo de pago es obligatorio cuando el pedido está pagado.',
        ];
    }
}
