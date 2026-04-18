<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $modelos = Stock::where('categoria', 'funda')
            ->distinct()->orderBy('modelo_celular')->pluck('modelo_celular');

        $disenios = Stock::where('categoria', 'funda')
            ->distinct()->orderBy('nombre_disenio')->pluck('nombre_disenio');

        $nombresAccesorio = Stock::where('categoria', 'accesorio')
            ->distinct()->orderBy('nombre_disenio')->pluck('nombre_disenio');

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
}
