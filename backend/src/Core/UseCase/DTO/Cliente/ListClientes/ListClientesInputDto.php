<?php

namespace Core\UseCase\DTO\Cliente\ListClientes;

class ListClientesInputDto
{
  public function __construct(
    public ?string $filter = null,
    public ?string $status = null,
    public string $orderBy = 'id',
    public string $orderDirection = 'DESC'
  ) {}
}
