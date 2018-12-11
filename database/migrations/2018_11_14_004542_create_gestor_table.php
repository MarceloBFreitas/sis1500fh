<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGestorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sisgestores', function (Blueprint $table) {
            $table->increments('gest_id');
            $table->integer('user_id')->unsigned();
            $table->float('custohora');
            $table->integer('horas_por_dia');
            $table->date('data_inicio');
            $table->rememberToken();
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('sisusers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sisgestores');
    }
}
