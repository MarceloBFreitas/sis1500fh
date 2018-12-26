<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBaseline extends Migration
{

    public function up()
    {
        Schema::create('sisbaseline', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('id_gestor')->nullable();
            $table->integer('id_projeto')->nullable();

            $table->string('cliente');
            $table->string('projeto');
            $table->float('tecn');
            $table->float('gestao');
            $table->string('mensuracao_descricao');
            $table->date('mensuracao_data');
            $table->string('objetivo');
            $table->float('custo_total');
            $table->float('valor_total');
            $table->float('valor_planejado');
            $table->float('horas_estimadas');
            $table->float('horas_totais');
            $table->float('horas_fim')->nullable();
            $table->integer('planejado')->nullable();
            $table->timestamps();


            $table->foreign('id_projeto')->references('id')->on('sisprojetos');
        });
    }


    public function down()
    {
        Schema::dropIfExists('sisbaseline');
    }
}
