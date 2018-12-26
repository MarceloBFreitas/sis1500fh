<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotoDetalhe extends Model
{
    protected $table = 'sisfoto_detalhe';

    protected $fillable = [
        'id_tpatv','id_projeto','horas_estimadas',

    ];
}
