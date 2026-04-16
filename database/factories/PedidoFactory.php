<?php

namespace Database\Factories;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoFactory extends Factory
{
    public function definition(): array
    {
        $stock = Stock::factory()->create();

        return [
            'user_id'        => User::factory(),
            'stock_id'       => $stock->id,
            'nombre_disenio' => $stock->nombre_disenio,
            'marca'          => $stock->modelo_celular,
            'modelo'         => '',
            'marca_id'       => null,
            'modelo_id'      => null,
            'nombre'         => fake()->firstName(),
            'apellido'       => fake()->lastName(),
            'precio'         => fake()->randomFloat(2, 500, 5000),
            'estado_pedido'  => 'disponible',
            'estado_pago'    => 'no_pagado',
            'tipo_pago'      => null,
        ];
    }
}
