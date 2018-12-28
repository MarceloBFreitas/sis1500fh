<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feriados extends Model
{

    protected $table = 'sisferiados';

    protected $fillable = [
        'data_feriado','nome_feriado'
    ];

}
