<?php

namespace Core\UseCase\Cliente;

use Core\Domain\Repository\ClienteRepositoryInterface;
use Core\UseCase\DTO\Cliente\ClienteOutputDto;
use Core\UseCase\DTO\Cliente\ListClientes\ListClientesInputDto;
use Core\UseCase\DTO\Cliente\ListClientes\ListClientesOutputDto;

class ListClientesUseCase
{
    protected ClienteRepositoryInterface $repository;

    public function __construct(ClienteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ListClientesInputDto $input): ListClientesOutputDto
    {
        $clientes = $this->repository->findAll(
            filter: $input->filter,
            order: $input->order
        );

        $outputItems = [];
        foreach ($clientes as $cliente) {
            $outputItems[] = new ClienteOutputDto(
                id: $cliente->id,
                nome: $cliente->nome,
                data_nascimento: $cliente->dataNascimento,
                tipo_pessoa: $cliente->tipoPessoa,
                cpf_cnpj: $cliente->cpfCnpj,
                email: $cliente->email,
                telefone: $cliente->telefone,
                id_endereco: $cliente->idEndereco,
                id_profissao: $cliente->idProfissao,
                status: $cliente->status,
                created_at: $cliente->createdAt(),
            );
        }

        return new ListClientesOutputDto(items: $outputItems);
    }
}
