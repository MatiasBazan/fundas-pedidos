<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $modelos = Cache::remember('stock_filter_modelos', now()->addMinutes(5), function () {
            return Stock::where('categoria', 'funda')
                ->distinct()->orderBy('modelo_celular')->pluck('modelo_celular');
        });

        $disenios = Cache::remember('stock_filter_disenios', now()->addMinutes(5), function () {
            return Stock::where('categoria', 'funda')
                ->distinct()->orderBy('nombre_disenio')->pluck('nombre_disenio');
        });

        $nombresAccesorio = Cache::remember('stock_filter_accesorios', now()->addMinutes(5), function () {
            return Stock::where('categoria', 'accesorio')
                ->distinct()->orderBy('nombre_disenio')->pluck('nombre_disenio');
        });

        $base = Stock::query()
            ->when($request->nombre_disenio, fn($q, $v) => $q->where('nombre_disenio', $v));

        $fondas = (clone $base)
            ->where('categoria', 'funda')
            ->when($request->modelo_celular, fn($q, $v) => $q->where('modelo_celular', $v))
            ->orderBy('modelo_celular')
            ->orderBy('nombre_disenio')
            ->paginate(30, ['*'], 'fondas')
            ->withQueryString();

        $accesorios = (clone $base)
            ->where('categoria', 'accesorio')
            ->orderBy('nombre_disenio')
            ->paginate(30, ['*'], 'accesorios')
            ->withQueryString();

        return view('stock.index', compact('fondas', 'accesorios', 'modelos', 'disenios', 'nombresAccesorio'));
    }

    public function destroy(Stock $stock)
    {
        // Verificar si el producto tiene pedidos asociados
        if ($stock->pedidoItems()->exists()) {
            return redirect()->route('stock.index')
                ->with('error', "No se puede eliminar «{$stock->nombre_disenio}» porque tiene pedidos asociados.");
        }

        $nombre = $stock->nombre_disenio;
        $stock->delete();

        return redirect()->route('stock.index')
            ->with('success', "Producto «{$nombre}» eliminado del stock.");
    }
}
