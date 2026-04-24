<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'categoria',
        'modelo_celular',
        'nombre_disenio',
        'cantidad',
    ];

    public function pedidoItems()
    {
        return $this->hasMany(PedidoItem::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
