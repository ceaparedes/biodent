<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comuna extends Model
{
    protected $table = 'comuna';
    protected $primaryKey = 'com_id';

    public function pacientes(){
    	return $this->belongsTo('App\Pacientes','com_id');
    }

    public function usuarios(){
    	return $this->belongsToMany('App\Usuarios','usu_id');
    }
    
}
