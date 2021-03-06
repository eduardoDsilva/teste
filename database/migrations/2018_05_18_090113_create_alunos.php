<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlunos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::create('alunos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('nascimento');
            $table->string('cpf')->nullable();
            $table->enum('sexo',['masculino','feminino', "nao especificado"])->default('nao especificado');
            $table->string('email')->nullable()->unique();
            $table->string('telefone')->nullable();
            $table->string('etapa');
            $table->string('turma', 50);
            $table->enum('camisa',['PP','P','M','G','GG'])->default('M');
            $table->string('rua')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cep')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->string('pais')->nullable();

            $table->unsignedInteger('escola_id');
            $table->foreign('escola_id')->references('id')->on('escolas')->onDelete('cascade');

            $table->unsignedInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias');

            $table->unsignedInteger('projeto_id')->nullable();
            $table->foreign('projeto_id')->references('id')->on('projetos');

            $table->timestamps();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('alunos');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
