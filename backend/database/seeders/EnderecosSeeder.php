<?php

namespace Database\Seeders;

use App\Models\Endereco;
use Illuminate\Database\Seeder;

class EnderecosSeeder extends Seeder
{
    public function run(): void
    {
        Endereco::factory()->count(10)->create();
    }
}
