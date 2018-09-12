<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tratamientos extends Model
{
    protected $table = 'tratamientos';
    protected $primaryKey = 'tra_id';

    protected $fillable = ['tra_nombre','tra_descripcion','tra_costo_laboratorio', 'tra_costo'];


    public function plan_de_tratamiento_tratamiento(){
		return $this->belongsToMany('App\PlanDeTratamientoTratamiento','tra_id');
	}

	public function sesiones_ejecucion_tratamientos(){
		return $this->belongsToMany('App\SesionesEjecucionTratamientos','tra_id');
	}


}
