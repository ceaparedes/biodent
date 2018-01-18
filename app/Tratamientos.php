<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tratamientos extends Model
{
    protected $table = 'tratamientos';
    protected $primaryKey = 'tra_id';

    protected $fillable = ['tra_nombre','tra_descripcion','tra_costo'];
}
