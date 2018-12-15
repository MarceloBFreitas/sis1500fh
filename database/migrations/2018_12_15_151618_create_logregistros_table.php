<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogregistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sislogregistros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_registro');
            $table->integer('id_projetodetalhe');
            $table->string('hora_fim_sugerida');
            $table->string('hora_fim_cadastrada');
            $table->string('qtd_horas_registradas');

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
        Schema::dropIfExists('sislogregistros');
    }
}
