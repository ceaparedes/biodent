<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbonosTratamientos extends Model
{
    
    protected $table = 'abonos_tratamientos';
    protected $primaryKey = 'abt_id';

    protected $fillable = ['abt_fecha', 'abt_monto_abonado'];

   
}
