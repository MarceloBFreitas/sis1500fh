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
                $table->integer('id_user');
                $table->string('descricao');
                $table->integer('id_atv_ed');
                $table->double('qtd_horas');
                $table->timestamps();
                $table->foreign('id_user')->references('id')->on('sisusers');
                $table->foreign('id_atv_ed')->references('id')->on('sisescopo_orcamento_detalhe');

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
