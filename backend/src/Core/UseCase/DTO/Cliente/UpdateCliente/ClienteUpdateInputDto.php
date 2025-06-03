<?php

namespace Core\UseCase\DTO\Cliente\UpdateCliente;

use Core\Domain\ValueObject\StatusCliente;
use Core\Domain\ValueObject\TipoPessoa;
use DateTime;

class ClienteUpdateInputDto
{
    public function __construct(
        public int $id,
        public string $nome,
        public DateTime $dataNascimento,
        public TipoPessoa $tipoPessoa,
        public string $cpfCnpj,
        public string $email,
        public string $telefone,
        public int $idEndereco,
        public int $idProfissao,
        public StatusCliente $status = StatusCliente::ATIVO,
    ) {}
}
