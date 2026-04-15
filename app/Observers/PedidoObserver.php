<?php

namespace App\Observers;

use App\Models\Pedido;
use App\Models\Stock;

class PedidoObserver
{
    public function created(Pedido $pedido): void
    {
        $stock = Stock::firstOrCreate(
            [
                'modelo_celular' => $pedido->modelo,
                'nombre_disenio' => $pedido->nombre_disenio,
            ],
            ['cantidad' => 0]
        );

        $stock->decrement('cantidad');
    }

    public function deleted(Pedido $pedido): void
    {
        $stock = Stock::where('modelo_celular', $pedido->modelo)
            ->where('nombre_disenio', $pedido->nombre_disenio)
            ->first();

        if ($stock) {
            $stock->increment('cantidad');
        }
    }
}
