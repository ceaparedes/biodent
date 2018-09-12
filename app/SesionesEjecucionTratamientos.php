<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SesionesEjecucionTratamientos extends Model
{
   
   protected $table = "sesiones_ejecucion_tratamientos";
   protected $primaryKey = 'set_id';

   protected $fillable = ['set_fecha', 'set_hora'];
}
