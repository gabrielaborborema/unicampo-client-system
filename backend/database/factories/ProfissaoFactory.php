<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProfissaoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome_profissao' => $this->faker->unique()->jobTitle,
        ];
    }
}
