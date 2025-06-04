<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Cliente as Model;
use App\Models\Cliente;
use App\Models\Endereco;
use App\Models\Profissao;
use App\Repositories\Eloquent\ClienteEloquentRepository;
use Core\Domain\Entity\Cliente as EntityCliente;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\ClienteRepositoryInterface;
use Core\Domain\ValueObject\TipoPessoa;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Throwable;

class ClienteEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ClienteEloquentRepository(new Model());
    }

    public function testInsert()
    {
        $endereco = Endereco::factory()->create();
        $profissao = Profissao::factory()->create();

        $entity = new EntityCliente(
            nome: 'Gabriela Borborema',
            dataNascimento: new DateTime('1990-01-01'),
            tipoPessoa: TipoPessoa::FISICA,
            cpfCnpj: '512.775.330-83',
            email: 'gabriela@example.com',
            telefone: '(11) 98765-4321',
            idEndereco: $endereco->id,
            idProfissao: $profissao->id,
        );

        $response = $this->repository->insert($entity);

        $this->assertInstanceOf(ClienteRepositoryInterface::class, $this->repository);
        $this->assertInstanceOf(EntityCliente::class, $response);
        $this->assertDatabaseHas('clientes', [
            'nome' => 'Gabriela Borborema',
            'data_nascimento' => '1990-01-01 00:00:00',
            'tipo_pessoa' => TipoPessoa::FISICA,
            'cpf_cnpj' => '512.775.330-83',
            'email' => 'gabriela@example.com',
            'telefone' => '(11) 98765-4321',
            'id_endereco' => $endereco->id,
            'id_profissao' => $profissao->id,
        ]);
    }

    public function testFindById()
    {
        Profissao::factory()->create();
        Endereco::factory()->create();
        $client = Model::factory()->create();

        $response = $this->repository->findById($client->id);

        $this->assertInstanceOf(EntityCliente::class, $response);
        $this->assertEquals($client->id, $response->id);
    }

    public function testFindByIdNotFound()
    {
        try {
            $this->repository->findById(20);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testFindAll()
    {
        Profissao::factory()->create();
        Endereco::factory()->create();
        $clients = Model::factory()->count(10)->create();

        $response = $this->repository->findAll();

        $this->assertEquals(count($clients), count($response));
    }

    public function testUpdate()
    {
        $endereco = Endereco::factory()->create();
        $profissao = Profissao::factory()->create();
        $clientPersisted = Model::factory()->create();

        $client = new EntityCliente(
            nome: 'Gabriela Borborema',
            dataNascimento: new DateTime('1990-01-01'),
            tipoPessoa: TipoPessoa::FISICA,
            cpfCnpj: '512.775.330-83',
            email: 'gabriela@example.com',
            telefone: '(11) 98765-4321',
            id: $clientPersisted->id,
            idEndereco: $endereco->id,
            idProfissao: $profissao->id,
        );
        $response = $this->repository->update($client);

        $this->assertInstanceOf(EntityCliente::class, $response);
        $this->assertNotEquals($response->nome, $clientPersisted->nome);
        $this->assertEquals('Gabriela Borborema', $response->nome);
    }

    public function testUpdateIdNotFound()
    {
        try {
            $client = new EntityCliente(
                nome: 'Gabriela Borborema',
                dataNascimento: new DateTime('1990-01-01'),
                tipoPessoa: TipoPessoa::FISICA,
                cpfCnpj: '512.775.330-83',
                email: 'gabriela@example.com',
                telefone: '(11) 98765-4321',
                idEndereco: 10,
                idProfissao: 20,
                id: 1,
            );
            $this->repository->update($client);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testDeleteIdNotFound()
    {
        try {
            $this->repository->delete(999);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testDelete()
    {
        $endereco = Endereco::factory()->create();
        $profissao = Profissao::factory()->create();
        $clientPersisted = Cliente::factory()->create();

        $response = $this->repository->delete($clientPersisted->id);

        $this->assertTrue($response);
    }
}
