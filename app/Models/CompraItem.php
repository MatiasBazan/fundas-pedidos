<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'compra_id',
        'categoria',
        'marca_id',
        'modelo_id',
        'modelo_celular',
        'nombre_disenio',
        'cantidad',
        'precio_unitario',
        'precio_total',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }
}
