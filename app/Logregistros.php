<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logregistros extends Model
{
    protected $table = 'sislogregistros';

    protected $fillable = [
        'id_registro','id_projetodetalhe','hora_fim_sugerida','hora_fim_cadastrada','qtd_horas_registradas'

    ];


}




