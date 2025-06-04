<?php

namespace Tests\Unit\App\Models;

use App\Models\Cliente;
use Core\Domain\ValueObject\StatusCliente;
use Core\Domain\ValueObject\TipoPessoa;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClienteUnitTest extends TestCase
{
    protected function model(): Model
    {
        return new Cliente();
    }

    public function testIfUseTraits()
    {
        $traitsNeeded = [
            HasFactory::class,
        ];

        $traitsUsed = array_keys(class_uses($this->model()));

        $this->assertEquals($traitsNeeded, $traitsUsed);
    }

    public function testHasCast()
    {
        $castsNeeded = [
            'id' => 'int',
            'data_nascimento' => 'datetime',
            'tipo_pessoa' => TipoPessoa::class,
            'status' => StatusCliente::class,
        ];
        dump($castsNeeded);
        $castsUsed = $this->model()->getCasts();
        dump($castsUsed);
        $this->assertEquals($castsNeeded, $castsUsed);
    }

    public function testFillable()
    {
        $fillableNeeded = [
            'nome',
            'data_nascimento',
            'tipo_pessoa',
            'cpf_cnpj',
            'email',
            'telefone',
            'id_endereco',
            'id_profissao',
            'status',
        ];

        $fillableUsed = $this->model()->getFillable();

        $this->assertEquals($fillableNeeded, $fillableUsed);
    }
}
