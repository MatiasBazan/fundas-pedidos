<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MarcaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre'          => fake()->unique()->lexify('Marca ??????'),
            'es_personalizada'=> false,
        ];
    }
}
