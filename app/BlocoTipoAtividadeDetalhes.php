<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlocoTipoAtividadeDetalhes extends Model
{
    protected $table = 'sisblocotipoatividade_detalhes';

    protected $fillable = [
        'id_bloco','id_tipoatividade','horas'
    ];


}
