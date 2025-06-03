<?php

namespace Core\UseCase\DTO\Cliente\CreateCliente;

use Core\Domain\ValueObject\StatusCliente;
use Core\Domain\ValueObject\TipoPessoa;
use DateTime;

class ClienteCreateOutputDto
{
    public function __construct(
        public int $id,
        public string $nome,
        public DateTime $data_nascimento,
        public TipoPessoa $tipo_pessoa,
        public string $cpf_cnpj,
        public string $email,
        public string $telefone,
        public int $id_endereco,
        public int $id_profissao,
        public StatusCliente $status = StatusCliente::ATIVO,
        public string|DateTime $created_at = '',
    ) {}
}
