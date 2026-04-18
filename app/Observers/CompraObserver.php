<?php

namespace App\Observers;

use App\Models\CompraItem;
use App\Models\Stock;

class CompraObserver
{
    public function created(CompraItem $item): void
    {
        $stock = Stock::firstOrCreate(
            [
                'categoria'      => $item->categoria,
                'modelo_celular' => $item->modelo_celular,
                'nombre_disenio' => $item->nombre_disenio,
            ],
            ['cantidad' => 0]
        );

        $stock->increment('cantidad', $item->cantidad);
    }

    public function deleted(CompraItem $item): void
    {
        $stock = Stock::where('categoria', $item->categoria)
            ->where('modelo_celular', $item->modelo_celular)
            ->where('nombre_disenio', $item->nombre_disenio)
            ->first();

        if ($stock) {
            $stock->decrement('cantidad', $item->cantidad);
        }
    }
}
