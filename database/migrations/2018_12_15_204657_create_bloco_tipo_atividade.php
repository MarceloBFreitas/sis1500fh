<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlocoTipoAtividade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sisblocotipoatividade', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tipoatividade');

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
        Schema::dropIfExists('sisblocotipoatividade');
    }
}
