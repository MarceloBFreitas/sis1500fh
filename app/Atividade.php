<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atividade extends Model
{
    protected $table = 'sisatividades';

    protected $fillable = [
        'nome','sigla', 'descricao', 'tipo',
    ];

}
