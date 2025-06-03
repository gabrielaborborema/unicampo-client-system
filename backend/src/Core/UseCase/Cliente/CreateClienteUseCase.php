<?php

namespace Core\UseCase\Cliente;

use Core\Domain\Entity\Cliente;
use Core\Domain\Repository\ClienteRepositoryInterface;
use Core\UseCase\DTO\Cliente\CreateCliente\{
    ClienteCreateInputDto,
    ClienteCreateOutputDto
};

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
            id: null,
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
            status: $newClient->status,
            created_at: $newClient->createdAt(),
        );
    }
}
