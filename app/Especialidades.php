<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialidades extends Model
{
	protected $table='Especialidades';
    protected $primaryKey = 'esp_id';

    protected $fillable = ['esp_nombre'];


    //join
    public function especialidad_usuario(){
    	return $this->belongsToMany('App\EspecialidadUsuario','esp_id');
    }
}
