<?php

namespace App\Models;

use Core\Domain\ValueObject\StatusCliente;
use Core\Domain\ValueObject\TipoPessoa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'data_nascimento',
        'tipo_pessoa',
        'cpf_cnpj',
        'email',
        'telefone',
        'id_endereco',
        'id_profissao',
        'status',

    ];

    protected $casts = [
        'data_nascimento' => 'datetime',
        'tipo_pessoa' => TipoPessoa::class,
        'status' => StatusCliente::class,
    ];
}
