<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ValidaPendencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sis_validaPendencias', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->String('cliente')->unsigned();
            $table->integer('id_projeto')->unsigned();
            $table->String('tipo_atv')->unsigned();
            $table->integer('id_atv_det')->nullable();
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->date('data')->nullable();
            $table->String('tema')->nullable();
            $table->String('comentario')->nullable();
            $table->String('status')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('sis_validaPendencias');
    }
}
