<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FotoDetalhes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sisfoto_detalhe', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('id_tpatv')->unsigned();
            $table->integer('id_foto')->unsigned();
            $table->integer('id_responsavel')->nullable();
            $table->String('descricao');
            $table->float('horas_estimadas');
            $table->float('horas_reais');
            $table->float('horas_fim');
            $table->String('predecessora')->nullable();

            $table->foreign('id_tpatv')->references('id')->on('sistipo_atividades');
            $table->foreign('id_foto')->references('id')->on('sisfotos');
            $table->foreign('id_responsavel')->references('id')->on('sisusers');


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
        Schema::dropIfExists('sisfoto_detalhe');
    }
}
