<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ValidaData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sis_validadata', function (Blueprint $table) {
            $table->increments('id')->unsigned();

            $table->String('cliente')->unsigned();
            $table->integer('id_projeto')->unsigned();

            $table->date('data_fim_base')->nullable();
            $table->date('data_fim_atual')->nullable();
            $table->date('fim_semana')->nullable();

            $table->date('data')->nullable();
            $table->String('tema')->nullable();
            $table->String('comentario')->nullable();
            $table->String('status')->nullable();


            $table->timestamps();
        });
    }


    public function down()
    {


        Schema::dropIfExists('sis_validadata');


    }
}