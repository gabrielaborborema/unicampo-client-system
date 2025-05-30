<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profissao extends Model
{
    /** @use HasFactory<\Database\Factories\ProfissaoFactory> */
    use HasFactory;

    protected $table = 'profissoes';

    protected $fillable = [
        'nome_profissao',
    ];
}
