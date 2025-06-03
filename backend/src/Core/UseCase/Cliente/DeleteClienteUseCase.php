<?php

namespace Core\UseCase\Cliente;

use Core\Domain\Entity\Cliente;
use Core\Domain\Repository\ClienteRepositoryInterface;
use Core\UseCase\DTO\Cliente\ClienteInputDto;
use Core\UseCase\DTO\Cliente\DeleteCliente\ClienteDeleteOutputDto;

class DeleteClienteUseCase
{
    protected $repository;

    public function __construct(ClienteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ClienteInputDto $input): ClienteDeleteOutputDto
    {
        $reponseDelete = $this->repository->delete($input->id);

        return new ClienteDeleteOutputDto(
            success: $reponseDelete,
        );
    }
}
