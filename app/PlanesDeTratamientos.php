<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanesDeTratamientos extends Model
{
    
    protected $table = 'planes_de_tratamientos';
    protected $primaryKey = 'pdt_id';

    protected $fillable = ['pdt_fecha_inicio', 'pdt_fecha_termino', 'pdt_detalle', 'pdt_costo_total', 'pac_id', 'usu_id', 'ept_id'];

     public function plan_de_tratamiento_tratamiento(){
		return $this->belongsToMany('App\PlanDeTratamientoTratamiento','pdt_id');
	}

	 public function usuarios(){
		return $this->belongsTo('App\Usuarios','pdt_id');
	}

	public function pacientes(){
		return $this->belongsTo('App\Pacientes','pac_id');
	}

	 public function abonos(){
    	return $this->belongsTo('App\AbonosTratamientos','pdt_id');
    }
}
