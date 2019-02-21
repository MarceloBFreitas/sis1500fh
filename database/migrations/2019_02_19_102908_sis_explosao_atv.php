<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SisExplosaoAtv extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sis_explosao_atv', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('id_microatv')->unsigned();
            $table->integer('id_tpatv')->unsigned();
            $table->integer('id_projeto')->unsigned();
            $table->integer('id_responsavel')->nullable();
            $table->String('descricao')->nullable();
            $table->float('horas_estimadas')->nullable();
            $table->float('horas_reais')->nullable();
            $table->float('horas_fim')->nullable();
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->string('explosao')->nullable();

            $table->String('predecessora')->nullable();



            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('sis_explosao_atv');

    }
}
