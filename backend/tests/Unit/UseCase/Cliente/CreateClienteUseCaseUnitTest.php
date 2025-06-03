<?php

namespace Tests\Unit\UseCase\Cliente;

use Core\Domain\Entity\Cliente;
use Core\Domain\Repository\ClienteRepositoryInterface;
use Core\Domain\ValueObject\StatusCliente;
use Core\Domain\ValueObject\TipoPessoa;
use Core\UseCase\Cliente\CreateClienteUseCase;
use Core\UseCase\DTO\Cliente\CreateCliente\ClienteCreateInputDto;
use Core\UseCase\DTO\Cliente\CreateCliente\ClienteCreateOutputDto;
use DateTime;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class CreateClienteUseCaseUnitTest extends TestCase
{
    private $mockEntity;
    private $mockRepo;
    private $mockInputDto;

    public function testCreateNewCliente()
    {
        $clienteId = 1;
        $clienteNome = 'Cliente Mock';
        $clienteDataNascimento = new DateTime('1990-01-01');
        $clienteTipoPessoa = TipoPessoa::FISICA;
        $clienteCpfCnpj = '512.775.330-83';
        $clienteEmail = 'mock@example.com';
        $clienteTelefone = '(11) 98765-4321';
        $clienteIdEndereco = 10;
        $clienteIdProfissao = 20;
        $clienteStatus = StatusCliente::ATIVO;

        $this->mockEntity = Mockery::mock(Cliente::class, [
            $clienteNome,
            $clienteDataNascimento,
            $clienteTipoPessoa,
            $clienteCpfCnpj,
            $clienteEmail,
            $clienteTelefone,
            $clienteId,
            $clienteIdEndereco,
            $clienteIdProfissao,
            $clienteStatus,
        ]);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepo = Mockery::mock(ClienteRepositoryInterface::class);
        $this->mockRepo->shouldReceive('insert')->once()->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(ClienteCreateInputDto::class, [
            $clienteNome,
            $clienteDataNascimento,
            $clienteTipoPessoa,
            $clienteCpfCnpj,
            $clienteEmail,
            $clienteTelefone,
            $clienteIdEndereco,
            $clienteIdProfissao,
            $clienteStatus,
        ]);

        $useCase = new CreateClienteUseCase($this->mockRepo);
        $responseUseCase = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(ClienteCreateOutputDto::class, $responseUseCase);
        $this->assertEquals($clienteNome, $responseUseCase->nome);
        $this->assertEquals($clienteDataNascimento, $responseUseCase->data_nascimento);
        $this->assertEquals($clienteTipoPessoa, $responseUseCase->tipo_pessoa);
        $this->assertEquals($clienteCpfCnpj, $responseUseCase->cpf_cnpj);
        $this->assertEquals($clienteEmail, $responseUseCase->email);
        $this->assertEquals($clienteTelefone, $responseUseCase->telefone);
        $this->assertEquals($clienteIdEndereco, $responseUseCase->id_endereco);
        $this->assertEquals($clienteIdProfissao, $responseUseCase->id_profissao);
        $this->assertEquals($clienteStatus, $responseUseCase->status);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
