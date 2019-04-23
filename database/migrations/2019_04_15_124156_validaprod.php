<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Validaprod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sis_validaProdutividade', function (Blueprint $table) {
            $table->increments('id')->unsigned();

            $table->String('cliente')->unsigned();
            $table->integer('id_projeto')->unsigned();

            $table->float('horas_plan')->nullable();
            $table->float('horas_projeto')->nullable();
            $table->float('horas_fim')->nullable();
            $table->date('data')->nullable();
            $table->String('tema')->nullable();
            $table->String('comentario')->nullable();
            $table->String('status')->nullable();



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
        Schema::dropIfExists('sis_validaProdutividade');
    }
}
