<?php

namespace Core\Domain\Entity;

use Core\Domain\ValueObject\StatusCliente;
use Core\Domain\Entity\Traits\MagicMethodsTrait;
use Core\Domain\Validation\DomainValidation;
use Core\Domain\ValueObject\TipoPessoa;
use Core\Domain\Exception\EntityValidationException;
use DateTime;
use Respect\Validation\Validator as v;

class Cliente
{
    use MagicMethodsTrait;

    public function __construct(
        protected string $nome,
        protected DateTime $dataNascimento,
        protected TipoPessoa $tipoPessoa,
        protected string $cpfCnpj,
        protected string $email,
        protected string $telefone,

        // replace with actual types
        protected int $idEndereco,
        protected int $idProfissao,
        protected ?int $id = null,
        protected StatusCliente $status = StatusCliente::ATIVO,
        protected DateTime|string $createdAt = '',
    ) {
        $this->createdAt = $this->createdAt ? new DateTime($this->createdAt) : new DateTime();

        $this->validate();
    }

    public function activate(): void
    {
        $this->status = StatusCliente::ATIVO;
    }

    public function deactivate(): void
    {
        $this->status = StatusCliente::INATIVO;
    }

    public function update(
        string $nome = null,
        DateTime $dataNascimento = null,
        TipoPessoa $tipoPessoa = null,
        string $cpfCnpj = null,
        string $email = null,
        string $telefone = null,
        int $idEndereco = null,
        int $idProfissao = null
    ) {
        $this->nome = $nome ?? $this->$nome;
        $this->dataNascimento = $dataNascimento ?? $this->dataNascimento;
        $this->tipoPessoa = $tipoPessoa ?? $this->tipoPessoa;
        $this->cpfCnpj = $cpfCnpj ?? $this->cpfCnpj;
        $this->email = $email ?? $this->email;
        $this->telefone = $telefone ?? $this->telefone;
        $this->idEndereco = $idEndereco ?? $this->idEndereco;
        $this->idProfissao = $idProfissao ?? $this->idProfissao;

        $this->validate();
    }

    private function validate()
    {
        DomainValidation::notNull($this->nome, 'Nome should not be empty.');
        DomainValidation::strMaxLength($this->nome, 100, "Nome should not be longer than 100 characters");

        DomainValidation::notNull($this->dataNascimento->format('Y-m-d'), 'Data de Nascimento should not be empty.');

        DomainValidation::notNull($this->tipoPessoa->value, 'Tipo de Pessoa should not be empty.');

        DomainValidation::notNull($this->cpfCnpj, 'CPF/CNPJ should not be empty.');
        $this->validateCpfCnpjMask();
        $this->validateCpfCnpj();

        DomainValidation::notNull($this->email, 'Email should not be empty.');
        $this->validateEmail();

        DomainValidation::notNull($this->telefone, 'Telefone should not be empty.');
        DomainValidation::strMaxLength($this->telefone, 20, "Telefone should not be longer than 255 characters");

        DomainValidation::notNull((string) $this->idEndereco, 'Endereco should not be empty.');
        DomainValidation::notNull((string) $this->idProfissao, 'Profissao should not be empty.');
        DomainValidation::notNull($this->status->value, 'Status should not be empty.');
    }

    private function validateCpfCnpj()
    {
        $cpfCnpjUnmasked = preg_replace('/[^0-9]/', '', $this->cpfCnpj);

        if ($this->tipoPessoa === TipoPessoa::FISICA) {
            if (!v::cpf()->validate($cpfCnpjUnmasked)) {
                throw new EntityValidationException('Invalid CPF. CPF must obey the digit verification');
            }
        } elseif ($this->tipoPessoa === TipoPessoa::JURIDICA) {
            if (!v::cnpj()->validate($cpfCnpjUnmasked)) {
                throw new EntityValidationException('Invalid CNPJ. CNPJ must obey the digit verification');
            }
        }
    }

    private function validateCpfCnpjMask()
    {
        if ($this->tipoPessoa === TipoPessoa::FISICA) {
            if (!preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $this->cpfCnpj)) {
                throw new EntityValidationException('Invalid CPF mask. Expected format: XXX.XXX.XXX-XX');
            }
        } elseif ($this->tipoPessoa === TipoPessoa::JURIDICA) {
            if (!preg_match('/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/', $this->cpfCnpj)) {
                throw new EntityValidationException('Invalid CNPJ mask. Expected format: XX.XXX.XXX/XXXX-XX');
            }
        }
    }

    private function validateEmail()
    {
        if (!v::email()->validate($this->email)) {
            throw new EntityValidationException('Invalid Email format.');
        }
    }
}
