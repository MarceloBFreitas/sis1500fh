<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriarTabelaEscopoOrcamentoDetalhe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sisescopo_orcamento_detalhe', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('id_atv')->unsigned();
            $table->integer('id_eo')->unsigned();
            $table->String('descricao');
            $table->float('horas_estimadas');
             $table->date('data_inicio')->nullable();
             $table->date('data_fim')->nullable();
            $table->string('explosao')->nullable();



            $table->foreign('id_atv')->references('id')->on('sistipo_atividades');
           $table->foreign('id_eo')->references('id')->on('sisescopo_orcamento');


            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('sisescopo_orcamento_detalhe');
    }
}
