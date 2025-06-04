<?php

namespace Core\UseCase\DTO\Cliente\ListClientes;

class ListClientesInputDto
{
  public function __construct(
    public string $filter = '',
    public string $order = 'DESC'
  ) {}
}
