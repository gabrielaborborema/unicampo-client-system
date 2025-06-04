<?php

namespace Core\UseCase\DTO\Cliente\ListClientes;

class ListClientesOutputDto
{
    public function __construct(
        public array $items
    ) {}
}
