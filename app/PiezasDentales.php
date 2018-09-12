<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PiezasDentales extends Model
{
     protected $table='piezas_dentales';
    protected $primaryKey = 'pde_id';

    protected $fillable = ['pde_id','pde_codigo_pieza','pde_nombre_pieza'];

}
