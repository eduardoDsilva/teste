<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvaliadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliadores', function (Blueprint $table) {
            $table->increments('id');

            //criando a FK dos projetos desse avaliador
            $table->unsignedInteger('projeto_id')->unique();
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');

            //criando a FK do usuario desse avaliador
            $table->unsignedInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            //criando FK de endereco
            $table->unsignedInteger('endereco_id')->nullable()->unique();
            $table->foreign('endereco_id')->references('id')->on('enderecos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('avaliadores');
    }
}
