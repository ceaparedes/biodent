<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EspecialidadOdontologo extends Model
{
    
	protected $table = 'especialidad_odontologo';
	protected $primaryKet = 'eso_id';

	protected $fillable = ['esp_id','odo_id'];

	
	public function especialidad(){
    	$this->belongstoMany('App\Especialidad','esp_id');
    }

    public function odontologo(){
    	$this->belongstoMany('App\Odontologos','odo_id');
    }



}
