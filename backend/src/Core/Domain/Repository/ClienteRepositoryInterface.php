<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Cliente;

interface ClienteRepositoryInterface
{
    public function insert(Cliente $client): Cliente;
    public function findById(int $id): Cliente;
    public function findAll(?string $filter = null, ?string $status = null, string $orderBy = 'id', string $orderDirection = 'DESC'): array;
    public function update(Cliente $client): Cliente;
    public function delete(int $id): bool;
}
