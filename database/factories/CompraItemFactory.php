<?php

namespace Database\Factories;

use App\Models\Compra;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompraItemFactory extends Factory
{
    public function definition(): array
    {
        $cantidad       = fake()->numberBetween(1, 10);
        $precioUnitario = fake()->randomFloat(2, 100, 1000);

        return [
            'compra_id'       => Compra::factory(),
            'marca_id'        => null,
            'modelo_id'       => null,
            'modelo_celular'  => fake()->lexify('Brand ??? Model ???'),
            'nombre_disenio'  => fake()->lexify('Diseño ???'),
            'cantidad'        => $cantidad,
            'precio_unitario' => $precioUnitario,
            'precio_total'    => round($cantidad * $precioUnitario, 2),
        ];
    }
}
