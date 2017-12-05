<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Odontologos extends Model
{
    protected $table = 'odontologos';
    protected $primaryKey = 'odo_id';

     protected $fillable = ['odo_rut', 'odo_dv', 'odo_nombres', 'odo_apellido_paterno', 'odo_apellido_materno', 'odo_fecha_nacimiento','odo_email', 'odo_telefono','odo_direccion','odo_direccion','odo_usuario','odo_password','odo_rol'] 

}
