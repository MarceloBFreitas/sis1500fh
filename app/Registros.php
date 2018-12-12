<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registros extends Model
{

    protected $table = 'sisregistros';
    protected $fillable = [
        'dia','id_user','id_projetodetalhe','descricao','qtd_horas'


    ];
}
