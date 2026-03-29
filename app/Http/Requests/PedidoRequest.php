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
            'nombre_disenio' => 'required|string|max:255',
            'marca_id' => 'required_without:marca_otra|nullable|exists:marcas,id',
            'marca_otra' => 'required_without:marca_id|nullable|string|max:100',
            'modelo_id' => 'required_without:modelo_otro|nullable|exists:modelos,id',
            'modelo_otro' => 'required_without:modelo_id|nullable|string|max:100',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'estado_pedido' => 'required|in:disponible,entregado',
            'estado_pago' => 'required|in:no_pagado,pagado',
            'tipo_pago' => 'nullable|in:efectivo,transferencia',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_disenio.required' => 'El nombre del diseño es obligatorio.',
            'marca_id.required_without' => 'Debe seleccionar una marca o ingresar una personalizada.',
            'marca_otra.required_without' => 'Debe ingresar una marca personalizada o seleccionar del catálogo.',
            'modelo_id.required_without' => 'Debe seleccionar un modelo o ingresar uno personalizado.',
            'modelo_otro.required_without' => 'Debe ingresar un modelo personalizado o seleccionar del catálogo.',
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio debe ser mayor o igual a 0.',
        ];
    }
}
