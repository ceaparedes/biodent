<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materiales extends Model
{
    protected $table = 'materiales';
    protected $primaryKey = 'mat_id';

    protected $fillable = ['mat_codigo', 'mat_nombre_material', 'mat_costo', 'mat_stock', 'mat_stock_minimo', 'mat_fecha_creacion', 'mat_estado', 'mat_unidad_medidia'];
}
