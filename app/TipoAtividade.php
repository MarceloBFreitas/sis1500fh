<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoAtividade extends Model
{
    protected $table = 'sistipo_atividades';

    protected $fillable = [
        'nome','sigla', 'descricao', 'tipo',
    ];

}
