<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->date('data_nascimento');
            $table->enum('tipo_pessoa', ['física', 'jurídica']);
            $table->string('cpf_cnpj', 18)->unique();
            $table->string('email')->unique();
            $table->string('telefone', 20);

            $table->foreignId('id_endereco')->constrained('enderecos')->onDelete('cascade');

            $table->foreignId('id_profissao')->constrained('profissoes')->onDelete('cascade');

            $table->enum('status', ['ativo', 'inativo']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
