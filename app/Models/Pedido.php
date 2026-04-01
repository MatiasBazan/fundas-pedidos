<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Pedido extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function marcaRelacion()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    public function modeloRelacion()
    {
        return $this->belongsTo(Modelo::class, 'modelo_id');
    }
}
