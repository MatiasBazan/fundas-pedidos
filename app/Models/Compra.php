<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $fillable = [
        'modelo_celular',
        'nombre_disenio',
        'cantidad',
        'precio_unitario',
        'precio_total',
        'observaciones',
    ];
}
