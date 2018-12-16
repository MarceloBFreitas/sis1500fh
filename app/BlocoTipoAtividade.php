<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlocoTipoAtividade extends Model
{
    protected $table = 'sisblocotipoatividade';

    protected $fillable = [
        'id_tipoatividade','nomegrupo'
    ];

}
