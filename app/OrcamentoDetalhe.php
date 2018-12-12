<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrcamentoDetalhe extends Model
{
    protected $table = 'sisescopo_orcamento_detalhe';

    protected $fillable = [
        'id_atv','descricao','horas_estimadas',

    ];
}
