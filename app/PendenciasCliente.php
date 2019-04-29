<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendenciasCliente extends Model
{
    protected $table = 'sis_validaPendencias';

    protected $fillable = [
        'id',
    ];
}
