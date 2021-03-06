<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;

class TiposAntecedentes extends Model
{
    protected $table='tipos_antecedentes';
    protected $primaryKey = 'tan_id';

    protected function antecedentes(){
    	
    	return $this->belongsTo('App\AntecedentesMedicosGenerales','amg_id');
    }
    
}
