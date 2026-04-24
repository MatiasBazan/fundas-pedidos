<?php

namespace App\Observers;

use App\Models\CompraItem;
use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Cache;

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

        $cantidadAnterior = $stock->cantidad;
        $stock->increment('cantidad', $item->cantidad);
        $stock->refresh();

        $this->registrarMovimiento($stock, 'compra_entrada', $item->cantidad, $cantidadAnterior, $stock->cantidad, 'compra', $item->compra_id);
        $this->invalidarCache();
    }

    public function deleted(CompraItem $item): void
    {
        $stock = Stock::where('categoria', $item->categoria)
            ->where('modelo_celular', $item->modelo_celular)
            ->where('nombre_disenio', $item->nombre_disenio)
            ->first();

        if ($stock) {
            $cantidadAnterior = $stock->cantidad;
            $stock->decrement('cantidad', $item->cantidad);
            $stock->cantidad = max(0, $stock->cantidad);
            $stock->save();

            $this->registrarMovimiento($stock, 'compra_eliminada', $item->cantidad, $cantidadAnterior, $stock->cantidad, 'compra', $item->compra_id);
            $this->invalidarCache();
        }
    }

    private function registrarMovimiento(Stock $stock, string $tipo, int $cantidad, int $cantidadAnterior, int $cantidadNueva, ?string $referenciaTipo = null, ?int $referenciaId = null): void
    {
        StockMovement::create([
            'stock_id'         => $stock->id,
            'tipo'            => $tipo,
            'cantidad'        => $cantidad,
            'cantidad_anterior' => $cantidadAnterior,
            'cantidad_nueva'   => $cantidadNueva,
            'referencia_tipo' => $referenciaTipo,
            'referencia_id'  => $referenciaId,
        ]);
    }

    private function invalidarCache(): void
    {
        Cache::forget('stock_filter_modelos');
        Cache::forget('stock_filter_disenios');
        Cache::forget('stock_filter_accesorios');
    }
}
