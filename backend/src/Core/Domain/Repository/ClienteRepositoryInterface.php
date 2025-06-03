<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Cliente;

interface ClienteRepositoryInterface
{
    public function insert(Cliente $client): Cliente;
    public function findById(int $id): Cliente;
    public function findByName(string $name): array;
    public function findAll(string $filter = '', $order = 'DESC'): array;
    public function update(Cliente $client): Cliente;
    public function delete(int $id): bool;
}
