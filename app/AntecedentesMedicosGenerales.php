<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntecedentesMedicosGenerales extends Model
{
	protected $table='antecedentes_medicos_generales';
    protected $primaryKey = 'amg_id';

    protected $fillable =['amg_id','pac_id','tan_id','amg_descripcion'];


    
    public function paciente(){

    	return $this->belongsTo('App\Paciente','pac_id');
    }
	

	public function tipo_antecedentes(){
		return $this->belongsTo('App\TiposAntecedentes','tan_id');
	}


}
