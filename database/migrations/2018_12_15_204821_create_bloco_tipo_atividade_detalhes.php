<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlocoTipoAtividadeDetalhes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sisblocotipoatividade_detalhes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_bloco');
            $table->integer('id_tipoatividade');
            $table->float('horas')->nullable();

            $table->foreign('id_bloco')->references('id')->on('sisblocotipoatividade');
            $table->foreign('id_tipoatividade')->references('id')->on('sistipo_atividades');
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
        Schema::dropIfExists('sisblocotipoatividade_detalhes');
    }
}
