<?php

namespace Core\UseCase\DTO\Cliente\DeleteCliente;

class ClienteDeleteOutputDto
{
    public function __construct(
        public bool $success
    ) {}
}
