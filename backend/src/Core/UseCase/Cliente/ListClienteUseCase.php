<?php

namespace Core\UseCase\Cliente;

use Core\Domain\Repository\ClienteRepositoryInterface;
use Core\UseCase\DTO\Cliente\{
    ClienteInputDto,
    ClienteOutputDto
};

class ListClienteUseCase
{
    protected $repository;

    public function __construct(ClienteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ClienteInputDto $input): ClienteOutputDto
    {
        $client = $this->repository->findById($input->id);

        return new ClienteOutputDto(
            nome: $client->nome,
            data_nascimento: $client->dataNascimento,
            tipo_pessoa: $client->tipoPessoa,
            cpf_cnpj: $client->cpfCnpj,
            email: $client->email,
            telefone: $client->telefone,
            id: $client->id,
            id_endereco: $client->idEndereco,
            id_profissao: $client->idProfissao,
            created_at: $client->createdAt(),
        );
    }
}
