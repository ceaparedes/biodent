<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialSesion extends Model
{
    protected $table = 'material_sesion';
    protected $primaryKey = 'mse_id';

    protected $fillable = ['mat_id', 'set_id'];
}
