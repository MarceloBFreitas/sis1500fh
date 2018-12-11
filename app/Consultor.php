<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultor extends Model
{
    protected $table = 'sisconsultores';
    public $primaryKey  = 'cons_id';
    protected $fillable = [
        'user_id','custohora', 'horas_por_dia', 'data_inicio'
    ];

    public function Usuarios(){
        return $this->belongsTo(User::class);
    }
}
