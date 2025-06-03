<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\ValueObject\StatusCliente;
use Core\Domain\Entity\Cliente;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\ValueObject\TipoPessoa;
use DateTime;
use PHPUnit\Framework\TestCase;
use Throwable;

class ClienteUnitTest extends TestCase
{
  public function testAttributes()
  {
    $client = new Cliente(
      id: 1,
      nome: 'Gabriela Borborema',
      dataNascimento: new DateTime('1990-01-01'),
      tipoPessoa: TipoPessoa::FISICA,
      cpfCnpj: '512.775.330-83',
      email: 'gabriela@example.com',
      telefone: '(11) 98765-4321',
      idEndereco: 10,
      idProfissao: 20,
      status: StatusCliente::ATIVO
    );

    $this->assertEquals($client->id, 1);
    $this->assertEquals($client->nome, 'Gabriela Borborema');
    $this->assertEquals($client->dataNascimento->format('Y-m-d'), '1990-01-01');
    $this->assertEquals($client->tipoPessoa, TipoPessoa::FISICA);
    $this->assertEquals($client->cpfCnpj, '512.775.330-83');
    $this->assertEquals($client->email, 'gabriela@example.com');
    $this->assertEquals($client->telefone, '(11) 98765-4321');
    $this->assertEquals($client->idEndereco, 10);
    $this->assertEquals($client->idProfissao, 20);
    $this->assertEquals(StatusCliente::ATIVO, $client->status);
    $this->assertNotEmpty($client->createdAt());
  }

  public function testActivate()
  {
    $client = new Cliente(
      id: 1,
      nome: 'Gabriela Borborema',
      dataNascimento: new DateTime('1990-01-01'),
      tipoPessoa: TipoPessoa::FISICA,
      cpfCnpj: '512.775.330-83',
      email: 'gabriela@example.com',
      telefone: '(11) 98765-4321',
      idEndereco: 10,
      idProfissao: 20,
      status: StatusCliente::INATIVO
    );

    $this->assertFalse($client->status->isActive());

    $client->activate();

    $this->assertTrue($client->status->isActive());
  }

  public function testDeactivate()
  {
    $client = new Cliente(
      id: 1,
      nome: 'Gabriela Borborema',
      dataNascimento: new DateTime('1990-01-01'),
      tipoPessoa: TipoPessoa::FISICA,
      cpfCnpj: '512.775.330-83',
      email: 'gabriela@example.com',
      telefone: '(11) 98765-4321',
      idEndereco: 10,
      idProfissao: 20,
      status: StatusCliente::ATIVO
    );

    $this->assertTrue($client->status->isActive());

    $client->deactivate();

    $this->assertFalse($client->status->isActive());
  }

  public function testUpdate()
  {
    $client = new Cliente(
      id: 1,
      nome: 'Gabriela Borborema',
      dataNascimento: new DateTime('1990-01-01'),
      tipoPessoa: TipoPessoa::FISICA,
      cpfCnpj: '512.775.330-83',
      email: 'gabriela@example.com',
      telefone: '(11) 98765-4321',
      idEndereco: 10,
      idProfissao: 20,
      status: StatusCliente::ATIVO,
      createdAt: '2025-01-01 00:00:00'
    );

    $client->update(
      nome: 'Gabriela Barreto',
      email: 'gabriela2@example.com',
      telefone: '(11) 11111-1111'
    );

    $this->assertEquals($client->nome, 'Gabriela Barreto');
    $this->assertEquals($client->email, 'gabriela2@example.com');
    $this->assertEquals($client->telefone, '(11) 11111-1111');
  }

  public function testExceptionCpfInvalid()
  {
    try {
      new Cliente(
        id: 1,
        nome: 'Gabriela Borborema',
        dataNascimento: new DateTime('1990-01-01'),
        tipoPessoa: TipoPessoa::FISICA,
        cpfCnpj: '123.456.789-00',
        email: 'gabriela@example.com',
        telefone: '(11) 98765-4321',
        idEndereco: 10,
        idProfissao: 20,
        status: StatusCliente::ATIVO
      );

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(EntityValidationException::class, $th, 'Invalid CPF.');
    }
  }

  public function testExceptionCnpjInvalid()
  {
    try {
      new Cliente(
        id: 1,
        nome: 'Gabriela Borborema',
        dataNascimento: new DateTime('1990-01-01'),
        tipoPessoa: TipoPessoa::JURIDICA,
        cpfCnpj: '12.345.678/0000-00',
        email: 'gabriela@example.com',
        telefone: '(11) 98765-4321',
        idEndereco: 10,
        idProfissao: 20,
        status: StatusCliente::ATIVO
      );

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(EntityValidationException::class, $th, 'Invalid CNPJ.');
    }
  }

  public function testExceptionCpfUnmasked()
  {
    try {
      new Cliente(
        id: 1,
        nome: 'Gabriela Borborema',
        dataNascimento: new DateTime('1990-01-01'),
        tipoPessoa: TipoPessoa::FISICA,
        cpfCnpj: '51277533083',
        email: 'gabriela@example.com',
        telefone: '(11) 98765-4321',
        idEndereco: 10,
        idProfissao: 20,
        status: StatusCliente::ATIVO
      );

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(EntityValidationException::class, $th, 'Invalid CPF mask. Expected format: XXX.XXX.XXX-XX');
    }
  }

  public function testExceptionCnpjUnmasked()
  {
    try {
      new Cliente(
        id: 1,
        nome: 'Gabriela Borborema',
        dataNascimento: new DateTime('1990-01-01'),
        tipoPessoa: TipoPessoa::FISICA,
        cpfCnpj: '19874032000144',
        email: 'gabriela@example.com',
        telefone: '(11) 98765-4321',
        idEndereco: 10,
        idProfissao: 20,
        status: StatusCliente::ATIVO
      );

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(EntityValidationException::class, $th, 'Invalid CNPJ mask. Expected format: XX.XXX.XXX/XXXX-XX');
    }
  }
}
