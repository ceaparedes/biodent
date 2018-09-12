<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanDeTratamientoTratamiento extends Model
{
    protected $table = 'plan_de_tratamiento_tratamiento';
    protected $primaryKey = 'ptt_id';

    protected $fillable = ['pdt_id', 'tra_id'];

     public function tratamientos(){
		return $this->belongsToMany('App\Tratamientos','tra_id');
	}

	public function planes_de_tratamientos(){
		return $this->belongsToMany('App\PlanesDeTratamientos','tra_id');
	}
}
