<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompraFactory extends Factory
{
    public function definition(): array
    {
        return [
            'fecha'        => fake()->date(),
            'observaciones'=> null,
        ];
    }
}
