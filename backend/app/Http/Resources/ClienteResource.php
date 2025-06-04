<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'data_nascimento' => $this->data_nascimento,
            'tipo_pessoa' => $this->tipo_pessoa,
            'cpf_cnpj' => $this->cpf_cnpj,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'id_endereco' => $this->id_endereco,
            'id_profissao' => $this->id_profissao,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
