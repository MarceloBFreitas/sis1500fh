<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'sisusers';
    protected $fillable = [
        'name', 'email', 'password','nivelacesso'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function Consultores()
    {
        return $this->hasMany(Consultor::class);
    }

    public function Gestores()
    {
        return $this->hasMany(Gestor::class);
    }

}
