<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecepcionesMateriales extends Model
{
    protected $table = 'recepciones_materiales';
    protected $primaryKey = 'rep_id';

    protected $fillable = ['rep_codigo', 'mat_id', 'rep_proveedor', 'rep_cantidad', 'rep_monto', 'rep_fecha_compra'];
}
