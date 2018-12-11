<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gestor extends Model
{
    protected $table = 'sisgestores';
    public $primaryKey  = 'gest_id';
    protected $fillable = [
        'user_id','custohora', 'horas_por_dia', 'data_inicio'
    ];

    public function Usuarios(){
        return $this->belongsTo(User::class);
    }
}
