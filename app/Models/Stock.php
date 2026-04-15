<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'modelo_celular',
        'nombre_disenio',
        'cantidad',
    ];
}
