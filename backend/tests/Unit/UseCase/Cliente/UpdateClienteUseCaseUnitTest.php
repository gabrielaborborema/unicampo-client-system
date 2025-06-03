<?php

namespace Tests\Unit\UseCase\Cliente;

use Core\Domain\Entity\Cliente as EntityCliente;
use Core\Domain\Repository\ClienteRepositoryInterface;
use Core\Domain\ValueObject\StatusCliente;
use Core\Domain\ValueObject\TipoPessoa;
use Core\UseCase\Cliente\UpdateClienteUseCase;
use Core\UseCase\DTO\Cliente\UpdateCliente\ClienteUpdateInputDto;
use Core\UseCase\DTO\Cliente\UpdateCliente\ClienteUpdateOutputDto;
use DateTime;
use Mockery;
use PHPUnit\Framework\TestCase;

class UpdateClienteUseCaseUnitTest extends TestCase
{
    private $mockEntity;
    private $mockRepo;
    private $mockInputDto;

    public function testRenameCliente()
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

        $this->mockEntity = Mockery::mock(EntityCliente::class, [
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
        $this->mockEntity->shouldReceive('update');

        $this->mockRepo = Mockery::mock(ClienteRepositoryInterface::class);
        $this->mockRepo->shouldReceive('findById')->once()->andReturn($this->mockEntity);
        $this->mockRepo->shouldReceive('update')->once()->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(ClienteUpdateInputDto::class, [
            $clienteId,
            'New Mock Name',
            $clienteDataNascimento,
            $clienteTipoPessoa,
            $clienteCpfCnpj,
            $clienteEmail,
            $clienteTelefone,
            $clienteIdEndereco,
            $clienteIdProfissao,
            $clienteStatus,
        ]);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $useCase = new UpdateClienteUseCase($this->mockRepo);
        $responseUseCase = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(ClienteUpdateOutputDto::class, $responseUseCase);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
