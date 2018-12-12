<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriarTabelaRegistros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::create('sisregistros', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->date('dia');
                $table->integer('id_user')->unsigned();
                $table->integer('id_projetodetalhe')->unsigned();
                $table->string('descricao');
                $table->double('qtd_horas');
                $table->double('horas_fim');
                $table->timestamps();
                $table->foreign('id_user')->references('id')->on('sisusers');
                $table->foreign('id_projetodetalhe')->references('id')->on('sisprojeto_detalhe');

            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sisregistros');
    }
}
