<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pacientes extends Model
{
    //Información Básica del modelo
    protected $table='pacientes';
    protected $primaryKey = 'pac_id';

    protected $fillable = ['pac_nombres','pac_apellido_paterno','pac_apellido_materno','pac_edad','pac_direccion','pac_telefono','pac_motivo','pac_observaciones','pac_rut','pac_dv','com_id', 'pac_fecha_nacimiento','pac_email'];

    
	public function antecedente(){
		return $this->belongsToMany('App\AntecedentesMedicosGenerales','pac_id');
	}

	public function comuna(){
		return $this->belongsTo('App\Comuna','pac_id');
	}

}
