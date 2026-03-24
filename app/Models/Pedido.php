<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'nombre_disenio',
        'modelo_celular',
        'nombre',
        'apellido',
        'precio',
        'estado_pedido',
        'estado_pago',
        'tipo_pago',
    ];
}
