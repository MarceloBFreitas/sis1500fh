<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orcamentoEscopo extends Model
{
    protected $table = 'sisescopo_orcamento';

    protected $fillable = [
        'cliente','objetivo','mensuracao','tecn','gestao',
    ];
}
