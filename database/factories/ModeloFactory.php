<?php

namespace Database\Factories;

use App\Models\Marca;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModeloFactory extends Factory
{
    public function definition(): array
    {
        return [
            'marca_id'       => Marca::factory(),
            'nombre'         => fake()->lexify('Modelo ??????'),
            'es_personalizado'=> false,
        ];
    }
}
