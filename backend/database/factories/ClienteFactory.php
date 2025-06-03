<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Endereco;
use App\Models\Profissao;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition(): array
    {
        $tipoPessoa = $this->faker->randomElement(['física', 'jurídica']);
        $cpfCnpj = '';
        if ($tipoPessoa === 'física') {
            $cpfCnpj = $this->faker->unique()->cpf();
        } else {
            $cpfCnpj = $this->faker->unique()->cnpj();
        }

        return [
            'nome' => $this->faker->name(),
            'data_nascimento' => $this->faker->date(),
            'tipo_pessoa' => $tipoPessoa,
            'cpf_cnpj' => $cpfCnpj,
            'email' => $this->faker->unique()->safeEmail(),
            'telefone' => $this->faker->phoneNumber(),
            'id_endereco' => Endereco::factory(),
            'id_profissao' => Profissao::inRandomOrder()->first()->id, // Assumes ProfissoesSeeder has run
            'status' => $this->faker->randomElement(['ativo', 'inativo']),
        ];
    }
}
