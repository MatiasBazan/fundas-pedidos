<?php

namespace App\Http\Controllers;

use App\Models\CompraItem;
use App\Models\Pedido;
use Illuminate\Support\Carbon;

class StatsController extends Controller
{
    public function index()
    {
        $userId    = auth()->id();
        $mesInicio = now()->startOfMonth();
        $mesFin    = now()->endOfMonth();

        $totalVendido  = Pedido::where('user_id', $userId)
            ->whereBetween('created_at', [$mesInicio, $mesFin])
            ->sum('precio_total');

        $totalComprado = CompraItem::whereHas('compra', fn($q) => $q->whereBetween('created_at', [$mesInicio, $mesFin]))
            ->sum('precio_total');

        $ganancia = $totalVendido - $totalComprado;

        $pedidosDisponibles = Pedido::where('user_id', $userId)
            ->where('estado_pedido', 'disponible')->count();

        $pedidosEntregados = Pedido::where('user_id', $userId)
            ->where('estado_pedido', 'entregado')->count();

        $pedidosPagados = Pedido::where('user_id', $userId)
            ->where('estado_pago', 'pagado')->count();

        $pedidosNoPagados = Pedido::where('user_id', $userId)
            ->where('estado_pago', 'no_pagado')->count();

        $ventasPorMes = Pedido::select('created_at', 'precio_total')
            ->where('user_id', $userId)
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->get()
            ->groupBy(fn($p) => $p->created_at->format('Y-m'))
            ->map(fn($group, $mes) => [
                'mes'   => Carbon::createFromFormat('Y-m', $mes)->translatedFormat('M Y'),
                'total' => round($group->sum('precio_total'), 2),
            ])
            ->sortKeys()
            ->values();

        $comprasPorMes = CompraItem::whereHas('compra', fn($q) => $q->where('created_at', '>=', now()->subMonths(5)->startOfMonth()))
            ->with('compra:id,created_at')
            ->get()
            ->groupBy(fn($item) => $item->compra->created_at->format('Y-m'))
            ->map(fn($group, $mes) => [
                'mes'   => Carbon::createFromFormat('Y-m', $mes)->translatedFormat('M Y'),
                'total' => round($group->sum('precio_total'), 2),
            ])
            ->sortKeys()
            ->values();

        return view('stats.index', compact(
            'totalVendido',
            'totalComprado',
            'ganancia',
            'pedidosDisponibles',
            'pedidosEntregados',
            'pedidosPagados',
            'pedidosNoPagados',
            'ventasPorMes',
            'comprasPorMes'
        ));
    }
}
