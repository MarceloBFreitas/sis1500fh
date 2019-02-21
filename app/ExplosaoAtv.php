<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExplosaoAtv extends Model
{
    protected $table = "sis_explosao_atv";
    protected $fillable = [
        'id_tpatv','id_projeto','horas_estimadas',

    ];
}
