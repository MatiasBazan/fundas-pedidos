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
            'fecha'                      => ['required', 'date'],
            'observaciones'              => ['nullable', 'string', 'max:500'],
            'items'                      => ['required', 'array', 'min:1'],
            'items.*.categoria'          => ['required', 'in:funda,accesorio'],
            'items.*.marca_id'           => ['nullable', 'integer', 'exists:marcas,id'],
            'items.*.marca_nueva'        => ['nullable', 'string', 'max:255'],
            'items.*.modelo_id'          => ['nullable', 'integer', 'exists:modelos,id'],
            'items.*.modelo_nuevo'       => ['nullable', 'string', 'max:255'],
            'items.*.nombre_disenio'     => ['required', 'string', 'max:255'],
            'items.*.cantidad'           => ['required', 'integer', 'min:1'],
            'items.*.precio_unitario'    => ['required', 'numeric', 'min:0'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($v) {
            foreach ($this->input('items', []) as $i => $item) {
                if (($item['categoria'] ?? 'funda') !== 'accesorio') {
                    if (empty($item['marca_id']) && empty($item['marca_nueva'])) {
                        $v->errors()->add("items.{$i}.marca_id", 'Seleccioná o ingresá una marca.');
                    }
                    if (empty($item['modelo_id']) && empty($item['modelo_nuevo'])) {
                        $v->errors()->add("items.{$i}.modelo_id", 'Seleccioná o ingresá un modelo.');
                    }
                }
            }
        });
    }
}
