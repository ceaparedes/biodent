<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pacientes extends Model
{
    //Información Básica del modelo
    protected $table='pacientes';
    protected $primaryKey = 'pac_id';
    protected $pac_rut_completo;

   

    protected $fillable = ['pac_nombres','pac_apellido_paterno','pac_apellido_materno','pac_edad','pac_direccion','pac_telefono','pac_motivo','pac_observaciones','pac_rut','pac_dv'];

	

}
