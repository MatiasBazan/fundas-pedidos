<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre_disenio',
        'marca',
        'modelo',
        'marca_id',
        'modelo_id',
        'nombre',
        'apellido',
        'precio',
        'estado_pedido',
        'estado_pago',
        'tipo_pago',
    ];

    public function marcaRelacion()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    public function modeloRelacion()
    {
        return $this->belongsTo(Modelo::class, 'modelo_id');
    }
}
