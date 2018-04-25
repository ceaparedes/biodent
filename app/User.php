<?php

namespace App;

use App\Usuarios;

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
    protected $table = 'usuarios';

    protected $primaryKey = 'usu_id';

    public function getAuthPassword()
    {
        return $this->usu_password;
    }

    protected $fillable = [
        'usu_usuario', 'usu_password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'usu_password', 'remember_token',
    ];

    

   
}
