<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->string('endereco', 200);
            $table->string('numero', 15);
            $table->string('bairro', 150);
            $table->string('complemento', 100)->nullable();
            $table->string('cidade', 100);
            $table->string('uf', 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enderecos');
    }
};
