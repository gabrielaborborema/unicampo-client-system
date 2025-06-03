<?php

namespace Core\UseCase\Cliente;

use Core\Domain\Entity\Cliente;
use Core\Domain\Repository\ClienteRepositoryInterface;
use Core\Domain\ValueObject\StatusCliente;
use Core\Domain\ValueObject\TipoPessoa;
use Core\UseCase\DTO\Cliente\{
  ClienteCreateInputDto,
  ClienteCreateOutputDto
};
use DateTime;

class CreateClienteUseCase
{
  protected $repository;

  public function __construct(ClienteRepositoryInterface $repository)
  {
    $this->repository = $repository;
  }

  public function execute(ClienteCreateInputDto $input): ClienteCreateOutputDto
  {
    $client = new Cliente(
      nome: $input->nome,
      dataNascimento: $input->dataNascimento,
      tipoPessoa: $input->tipoPessoa,
      cpfCnpj: $input->cpfCnpj,
      email: $input->email,
      telefone: $input->telefone,
      idEndereco: $input->idEndereco,
      idProfissao: $input->idProfissao,
      status: $input->status
    );

    $newClient = $this->repository->insert($client);

    return new ClienteCreateOutputDto(
      id: $newClient->id,
      nome: $newClient->nome,
      data_nascimento: $newClient->dataNascimento,
      tipo_pessoa: $newClient->tipoPessoa,
      cpf_cnpj: $newClient->cpfCnpj,
      email: $newClient->email,
      telefone: $newClient->telefone,
      id_endereco: $newClient->idEndereco,
      id_profissao: $newClient->idProfissao,
      status: $newClient->status
    );
  }
}
