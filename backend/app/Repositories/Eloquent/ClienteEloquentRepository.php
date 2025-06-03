<?php

namespace App\Repositories\Eloquent;

use App\Models\Cliente as Model;
use Core\Domain\Entity\Cliente as EntityCliente;
use Core\Domain\Repository\ClienteRepositoryInterface;
use Core\Domain\ValueObject\StatusCliente;
use Core\Domain\ValueObject\TipoPessoa;
use DateTime;

class ClienteEloquentRepository implements ClienteRepositoryInterface
{
    protected $model;

    public function __construct(Model $client)
    {
        $this->model = $client;
    }

    public function insert(EntityCliente $client): EntityCliente
    {
        $client = $this->model->create([
            'nome' => $client->nome,
            'data_nascimento' => $client->dataNascimento,
            'tipo_pessoa' => $client->tipoPessoa,
            'cpf_cnpj' => $client->cpfCnpj,
            'email' => $client->email,
            'telefone' => $client->telefone,
            'id_endereco' => $client->idEndereco,
            'id_profissao' => $client->idProfissao,
            'status' => $client->status,
            'created_at' => $client->createdAt(),
        ]);

        return $this->toCliente($client);
    }

    public function findById(int $id): EntityCliente
    {
        return new EntityCliente(
            nome: 'asdasd',
            dataNascimento: new DateTime(),
            tipoPessoa: TipoPessoa::FISICA,
            cpfCnpj: '',
            email: 'email@email.com',
            telefone: '(11) 98765-4321',    
            idEndereco: 2,
            idProfissao: 3,
        );
    }

    public function findByName(string $name): array
    {
        return [];
    }

    public function findAll(string $filter = '', $order = 'DESC'): array
    {
        return [];
    }

    public function update(EntityCliente $client): EntityCliente
    {
        return new EntityCliente(
            nome: $client->nome,
            dataNascimento: $client->dataNascimento,
            tipoPessoa: $client->tipoPessoa,
            cpfCnpj: $client->cpfCnpj,
            email: $client->email,
            telefone: $client->telefone,
            id: $client->id,
            idEndereco: $client->idEndereco,
            idProfissao: $client->idProfissao,
            status: $client->status,
            createdAt: $client->created_at,
        );
    }
    public function delete(int $id): bool
    {
        return true;
    }

    private function toCliente(object $object): EntityCliente
    {
        return new EntityCliente(
            nome: $object->nome,
            dataNascimento: $object->dataNascimento,
            tipoPessoa: $object->tipoPessoa,
            cpfCnpj: $object->cpfCnpj,
            email: $object->email,
            telefone: $object->telefone,
            id: $object->id,
            idEndereco: $object->idEndereco,
            idProfissao: $object->idProfissao,
            status: $object->status,
            createdAt: $object->created_at,
        );
    }
}
