<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'usu_id';

    protected $fillable = ['usu_rut', 'usu_dv', 'usu_nombres', 'usu_apellido_paterno', 'usu_apellido_materno', 'usu_fecha_nacimiento', 'usu_email', 'usu_telefono', 'usu_direccion', 'usu_usuario', 'usu_password', 'usu_rol', 'com_id'];

    public function especialidad_Usuario(){
    	$this->belongsToMany('App\EspecialidadUsuario', 'usu_id');
    }

    public function getAuthPassword()
    {
        return $this->usu_password;
    }
}
