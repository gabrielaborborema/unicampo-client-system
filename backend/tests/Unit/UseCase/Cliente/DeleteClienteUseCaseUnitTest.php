<?php

namespace Tests\Unit\UseCase\Cliente;

use Core\Domain\Entity\Cliente as EntityCliente;
use Core\Domain\Repository\ClienteRepositoryInterface;
use Core\Domain\ValueObject\StatusCliente;
use Core\Domain\ValueObject\TipoPessoa;
use Core\UseCase\Cliente\DeleteClienteUseCase;
use Core\UseCase\DTO\Cliente\ClienteInputDto;
use Core\UseCase\DTO\Cliente\DeleteCliente\ClienteDeleteOutputDto;
use DateTime;
use Mockery;
use PHPUnit\Framework\TestCase;

class DeleteClienteUseCaseUnitTest extends TestCase
{
    private $mockEntity;
    private $mockRepo;
    private $mockInputDto;

    public function testDeleteCliente()
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

        $this->mockRepo = Mockery::mock(ClienteRepositoryInterface::class);
        $this->mockRepo->shouldReceive('delete')->once()->andReturn(true);

        $this->mockInputDto = Mockery::mock(ClienteInputDto::class, [
            $clienteId,
        ]);

        $useCase = new DeleteClienteUseCase($this->mockRepo);
        $responseUseCase = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(ClienteDeleteOutputDto::class, $responseUseCase);
        $this->assertTrue($responseUseCase->success);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
