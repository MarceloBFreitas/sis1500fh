<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registros extends Model
{

    protected $table = 'sisregistros';
    protected $fillable = [
        'dia','descricao','id_atv_ed','qtd_horas','id_user'


    ];
}
