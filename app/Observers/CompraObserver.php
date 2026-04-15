<?php

namespace App\Observers;

use App\Models\Compra;
use App\Models\Stock;

class CompraObserver
{
    public function created(Compra $compra): void
    {
        $stock = Stock::firstOrCreate(
            [
                'modelo_celular' => $compra->modelo_celular,
                'nombre_disenio' => $compra->nombre_disenio,
            ],
            ['cantidad' => 0]
        );

        $stock->increment('cantidad', $compra->cantidad);
    }

    public function deleted(Compra $compra): void
    {
        $stock = Stock::where('modelo_celular', $compra->modelo_celular)
            ->where('nombre_disenio', $compra->nombre_disenio)
            ->first();

        if ($stock) {
            $stock->decrement('cantidad', $compra->cantidad);
        }
    }
}
