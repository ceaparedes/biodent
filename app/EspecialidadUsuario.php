<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EspecialidadUsuario extends Model
{
    
	protected $table = 'especialidad_usuario';
	protected $primaryKey = 'esu_id';

	protected $fillable = ['esp_id','odo_id'];

	
	public function especialidad(){
    	$this->belongstoMany('App\Especialidades','esp_id');
    }

    public function usuario(){
    	$this->belongstoMany('App\Usuarios','odo_id');
    }



}
