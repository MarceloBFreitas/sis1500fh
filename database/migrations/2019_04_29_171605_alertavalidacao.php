<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Alertavalidacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sis_alertavalidacao', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('id_projeto')->unsigned();
            $table->integer('escopo')->unsigned();
            $table->integer('objetivo')->unsigned();
            $table->integer('data')->unsigned();
            $table->integer('orcamento')->unsigned();
            $table->integer('produtividade')->unsigned();
            $table->integer('pendencias')->unsigned();


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
        Schema::dropIfExists('sis_alertavalidacao');
    }
}
