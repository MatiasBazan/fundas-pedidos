<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    public function definition(): array
    {
        return [
            'modelo_celular' => fake()->unique()->lexify('Brand ??? Model ???'),
            'nombre_disenio' => fake()->lexify('Diseño ???'),
            'categoria'     => 'funda',
            'cantidad'      => 5,
        ];
    }
}
