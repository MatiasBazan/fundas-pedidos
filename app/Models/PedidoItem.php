<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
    protected $fillable = [
        'pedido_id',
        'stock_id',
        'modelo_celular',
        'nombre_disenio',
        'categoria',
        'cantidad',
        'precio_unitario',
        'precio_total',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
