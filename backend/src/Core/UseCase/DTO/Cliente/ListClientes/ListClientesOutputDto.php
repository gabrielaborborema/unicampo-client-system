<?php

namespace Core\UseCase\DTO\Cliente\ListClientes;

use Core\UseCase\DTO\Cliente\ClienteOutputDto;

class ListClientesOutputDto
{
    public function __construct(
        public array $items
    ) {}
}
