<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    protected $table = 'sisprojetos';

    protected $fillable = [
        'cliente','projeto','tecn','gestao','mensuracao_data',
    ];
}

