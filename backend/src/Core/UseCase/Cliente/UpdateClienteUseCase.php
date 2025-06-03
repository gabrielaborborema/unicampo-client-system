<?php

namespace Core\UseCase\Cliente;

use App\Models\Cliente;
use Core\Domain\Repository\ClienteRepositoryInterface;
use Core\UseCase\DTO\Cliente\UpdateCliente\{
    ClienteUpdateInputDto,
    ClienteUpdateOutputDto
};

class UpdateClienteUseCase
{
    protected $repository;

    public function __construct(ClienteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ClienteUpdateInputDto $input): ClienteUpdateOutputDto
    {
        $client = $this->repository->findById($input->id);

        $client->update(
            nome: $input->nome,
            dataNascimento: $input->dataNascimento,
            tipoPessoa: $input->tipoPessoa,
            cpfCnpj: $input->cpfCnpj,
            email: $input->email,
            telefone: $input->telefone,
            idEndereco: $input->idEndereco,
            idProfissao: $input->idProfissao
        );

        $clientUpdated = $this->repository->update($client);

        return new ClienteUpdateOutputDto(
            id: $clientUpdated->id,
            nome: $clientUpdated->nome,
            data_nascimento: $clientUpdated->dataNascimento,
            tipo_pessoa: $clientUpdated->tipoPessoa,
            cpf_cnpj: $clientUpdated->cpfCnpj,
            email: $clientUpdated->email,
            telefone: $clientUpdated->telefone,
            id_endereco: $clientUpdated->idEndereco,
            id_profissao: $clientUpdated->idProfissao,
            status: $clientUpdated->status,
            created_at: $clientUpdated->createdAt(),
        );
    }
}
