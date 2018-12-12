<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriarTabelaEscopoOrcamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sisescopo_orcamento', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('cliente');
            $table->string('projeto');
            $table->float('tecn');
            $table->float('gestao');
            $table->string('mensuracao_descricao');
            $table->date('mensuracao_data');
            $table->string('objetivo');
            $table->integer('status');
            $table->float('valor_total');
            $table->float('horas_totais');
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
        Schema::dropIfExists('sisescopo_orcamento');
    }
}
