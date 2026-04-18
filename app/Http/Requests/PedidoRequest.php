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
            'items'                   => ['required', 'array', 'min:1'],
            'items.*.stock_id'        => ['required', 'integer', 'exists:stocks,id'],
            'items.*.cantidad'        => ['required', 'integer', 'min:1'],
            'items.*.precio_unitario' => ['required', 'numeric', 'min:0'],
            'nombre'                  => ['required', 'string', 'max:255'],
            'apellido'                => ['required', 'string', 'max:255'],
            'estado_pedido'           => ['required', 'in:disponible,entregado'],
            'estado_pago'             => ['required', 'in:no_pagado,pagado'],
            'tipo_pago'               => [$this->input('estado_pago') === 'pagado' ? 'required' : 'nullable', 'in:efectivo,transferencia'],
        ];
    }

    public function messages(): array
    {
        return [
            'items.required'                   => 'Debe agregar al menos un producto.',
            'items.*.stock_id.required'        => 'Seleccioná un producto para cada ítem.',
            'items.*.stock_id.exists'          => 'Uno de los productos seleccionados no existe en stock.',
            'items.*.cantidad.required'        => 'La cantidad es obligatoria.',
            'items.*.cantidad.min'             => 'La cantidad debe ser al menos 1.',
            'items.*.precio_unitario.required' => 'El precio unitario es obligatorio.',
            'items.*.precio_unitario.min'      => 'El precio debe ser mayor o igual a 0.',
            'nombre.required'                  => 'El nombre es obligatorio.',
            'apellido.required'                => 'El apellido es obligatorio.',
            'tipo_pago.required'               => 'El tipo de pago es obligatorio cuando el estado es pagado.',
        ];
    }
}
