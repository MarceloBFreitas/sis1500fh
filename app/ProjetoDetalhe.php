<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjetoDetalhe extends Model
{
    protected $table = 'sisprojeto_detalhe';

    protected $fillable = [
        'id_tpatv','id_projeto','horas_estimadas',

    ];
}
