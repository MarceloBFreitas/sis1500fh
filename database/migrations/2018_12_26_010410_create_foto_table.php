<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sisfotos', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('id_projeto')->unsigned();
            $table->integer('id_gestor')->nullable();
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
            $table->date('data_foto')->nullable();
            $table->timestamps();

            $table->foreign('id_gestor')->references('gest_id')->on('sisgestores');
            $table->foreign('id_projeto')->references('id')->on('sisprojetos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sisfotos');
    }
}
