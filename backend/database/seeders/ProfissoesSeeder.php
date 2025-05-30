<?php

namespace Database\Seeders;

use App\Models\Profissao;
use Illuminate\Database\Seeder;

class ProfissoesSeeder extends Seeder
{
    public function run(): void
    {
        $nomesProfissoes = [
            'Administração',
            'Consultor',
            'Contabilidade',
            'Engenheiro de Software',
            'Logística',
            'Recursos Humanos',
        ];

        foreach ($nomesProfissoes as $nome) {
            Profissao::firstOrCreate(
                ['nome_profissao' => $nome]
            );
        }
    }
}
