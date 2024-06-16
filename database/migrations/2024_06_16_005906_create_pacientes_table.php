<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('idade');
            $table->string('cpf')->unique();
            $table->string('rg')->unique();
            $table->date('data_nasc');
            $table->string('sexo');
            $table->string('signo');
            $table->string('mae');
            $table->string('pai');
            $table->string('email');
            $table->string('senha');
            $table->string('cep');
            $table->string('endereco');
            $table->integer('numero');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado');
            $table->string('telefone_fixo');
            $table->string('celular');
            $table->float('altura');
            $table->integer('peso');
            $table->string('tipo_sanguineo');
            $table->string('cor');

            $table->index('nome');
            $table->index('cpf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
