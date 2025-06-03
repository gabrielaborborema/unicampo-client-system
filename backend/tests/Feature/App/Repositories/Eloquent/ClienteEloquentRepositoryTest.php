<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Cliente as Model;
use App\Repositories\Eloquent\ClienteEloquentRepository;
use Core\Domain\Entity\Cliente as EntityCliente;
use Core\Domain\Repository\ClienteRepositoryInterface;
use Core\Domain\ValueObject\TipoPessoa;
use DateTime;
use Tests\TestCase;

class ClienteEloquentRepositoryTest extends TestCase
{
    public function testInsert()
    {
        $repository = new ClienteEloquentRepository(new Model());

        $entity = new EntityCliente(
            nome: 'Gabriela Borborema',
            dataNascimento: new DateTime('1990-01-01'),
            tipoPessoa: TipoPessoa::FISICA,
            cpfCnpj: '19874032000144',
            email: 'gabriela@example.com',
            telefone: '(11) 98765-4321',
            idEndereco: 10,
            idProfissao: 20,
        );

        $response = $repository->insert($entity);

        $this->assertInstanceOf(ClienteRepositoryInterface::class, $repository);
        $this->assertInstanceOf(EntityCliente::class, $response);
        $this->assertDatabaseHas('clientes', [
            'nome' => 'Gabriela Borborema',
            'data_nascimento' => '1990-01-01 00:00:00',
            'tipo_pessoa' => TipoPessoa::FISICA,
            'cpf_cnpj' => '19874032000144',
            'email' => 'gabriela@example.com',
            'telefone' => '(11) 98765-4321',
            'id_endereco' => 10,
            'id_profissao' => 20,
        ]);
    }
}
