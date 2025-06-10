<?php

namespace App\Repositories\Eloquent;

use App\Models\Cliente as Model;
use Core\Domain\Entity\Cliente as EntityCliente;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\ClienteRepositoryInterface;

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

    public function findById(int $clientId): EntityCliente
    {
        if (!$client = $this->model->find($clientId)) {
            throw new NotFoundException('Cliente not found.');
        }

        return $this->toCliente($client);
    }

    public function findAll(?string $filter = null, ?string $status = null, string $orderBy = 'id', string $orderDirection = 'DESC'): array
    {
        $query = $this->model->newQuery();

        if ($filter) {
            $query->where(function ($q) use ($filter) {
                $q->where('nome', 'LIKE', "%{$filter}%");
            });
        }

        if ($status) {
            //$correctedStatus = (strtoupper($status) === 'ativo') ? 'ativo' : 'inativo';
            $query->where('status', $status);
        }

        $allowedOrderByColumns = ['id', 'nome', 'created_at'];
        if (in_array(strtolower($orderBy), $allowedOrderByColumns)) {
            $direction = (strtoupper($orderDirection) === 'ASC') ? 'ASC' : 'DESC';
            $query->orderBy($orderBy, $direction);
        } else {
            $query->orderBy('id', 'DESC');
        }

        $clients = $query->get();


        return $clients->map(function ($client) {
            return $this->toCliente($client);
        })->all();
    }

    public function update(EntityCliente $client): EntityCliente
    {
        if (!$clientPersisted = $this->model->find($client->id)) {
            throw new NotFoundException('Cliente not found.');
        }

        $clientPersisted->update([
            'nome' => $client->nome,
            'data_nascimento' => $client->dataNascimento,
            'tipo_pessoa' => $client->tipoPessoa,
            'cpf_cnpj' => $client->cpfCnpj,
            'email' => $client->email,
            'telefone' => $client->telefone,
            'id_endereco' => $client->idEndereco,
            'id_profissao' => $client->idProfissao,
            'status' => $client->status,
        ]);

        $clientPersisted->refresh();

        return $this->toCliente($clientPersisted);
    }

    public function delete(int $clientId): bool
    {
        if (!$clientPersisted = $this->model->find($clientId)) {
            throw new NotFoundException('Cliente not found.');
        }

        return $clientPersisted->delete();
    }

    private function toCliente(object $object): EntityCliente
    {
        return new EntityCliente(
            nome: $object->nome,
            dataNascimento: $object->data_nascimento,
            tipoPessoa: $object->tipo_pessoa,
            cpfCnpj: $object->cpf_cnpj,
            email: $object->email,
            telefone: $object->telefone,
            id: $object->id,
            idEndereco: $object->id_endereco,
            idProfissao: $object->id_profissao,
            status: $object->status,
            createdAt: $object->created_at,
        );
    }
}
