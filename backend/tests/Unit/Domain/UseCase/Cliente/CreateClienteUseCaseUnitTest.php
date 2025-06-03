<?php

namespace Tests\Unit\Domain\UseCase\Cliente;

use Core\Domain\Entity\Cliente;
use Core\Domain\Repository\ClienteRepositoryInterface;
use Core\Domain\ValueObject\StatusCliente;
use Core\Domain\ValueObject\TipoPessoa;
use Core\UseCase\Cliente\CreateClienteUseCase;
use DateTime;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class CreateClienteUseCaseUnitTest extends TestCase
{
  private $mockEntity;

  private $mockRepo;

  public function testCreateNewCliente()
  {
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
      $clienteIdEndereco,
      $clienteIdProfissao,
      $clienteStatus,
    ]);

    $this->mockRepo = Mockery::mock(ClienteRepositoryInterface::class);
    $this->mockRepo->shouldReceive('insert')->andReturn($this->mockEntity);

    $useCase = new CreateClienteUseCase($this->mockRepo);
    $useCase->execute();

    Mockery::close();
  }
}
