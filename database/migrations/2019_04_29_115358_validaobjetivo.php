<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Validaobjetivo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sis_validaobjetivo', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->String('cliente')->unsigned();
            $table->integer('id_projeto')->unsigned();

            $table->date('data')->nullable();
            $table->date('mensuracao_data')->nullable();
            $table->String('tema')->nullable();
            $table->String('mensuracao')->nullable();
            $table->String('resultado')->nullable();
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
        Schema::dropIfExists('sis_validaobjetivo');
    }
}
