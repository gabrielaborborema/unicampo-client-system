<?php

namespace Database\Factories;

use App\Models\Endereco;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnderecoFactory extends Factory
{
    protected $model = Endereco::class;

    public function definition(): array
    {
        return [
            'endereco' => $this->faker->streetName,
            'numero' => $this->faker->buildingNumber,
            'bairro' => sprintf('%s %s', $this->faker->cityPrefix(), $this->faker->lastName()),
            'complemento' => $this->faker->optional()->secondaryAddress,
            'cidade' => $this->faker->city,
            'uf' => $this->faker->stateAbbr,
        ];
    }
}
