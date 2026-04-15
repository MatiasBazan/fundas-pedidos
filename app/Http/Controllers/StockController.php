<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $stocks = Stock::query()
            ->when($request->modelo_celular, fn($q, $v) => $q->where('modelo_celular', 'like', "%{$v}%"))
            ->when($request->nombre_disenio, fn($q, $v) => $q->where('nombre_disenio', 'like', "%{$v}%"))
            ->orderBy('modelo_celular')
            ->orderBy('nombre_disenio')
            ->paginate(30)
            ->withQueryString();

        return view('stock.index', compact('stocks'));
    }
}
