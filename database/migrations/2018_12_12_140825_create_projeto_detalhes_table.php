<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjetoDetalhesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sisprojeto_detalhe', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('id_tpatv')->unsigned();
            $table->integer('id_projeto')->unsigned();
            $table->String('descricao');
            $table->float('horas_estimadas');
            $table->float('horas_reais');
            $table->float('horas_fim');


            $table->foreign('id_tpatv')->references('id')->on('sistipo_atividades');
            $table->foreign('id_projeto')->references('id')->on('sisprojetos');


            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('sisescopo_orcamento_detalhe');
    }
}
