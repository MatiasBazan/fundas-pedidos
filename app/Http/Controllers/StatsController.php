<?php

namespace App\Http\Controllers;

use App\Models\CompraItem;
use App\Models\Pedido;
use Illuminate\Support\Carbon;

class StatsController extends Controller
{
    public function index()
    {
        $userId        = auth()->id();
        $mesRaw        = request('mes', now()->month);
        $anio          = (int) request('anio', now()->year);
        $todosPeriodos = ($mesRaw === '' || $mesRaw === '0');
        $mes           = $todosPeriodos ? '' : (int) $mesRaw;

        $mesInicio     = $todosPeriodos ? null : Carbon::createFromDate($anio, $mes, 1)->startOfMonth();
        $mesFin        = $todosPeriodos ? null : Carbon::createFromDate($anio, $mes, 1)->endOfMonth();
        $graficoInicio = $todosPeriodos
            ? now()->subMonths(11)->startOfMonth()
            : Carbon::createFromDate($anio, $mes, 1)->subMonths(4)->startOfMonth();
        $graficoFin    = $todosPeriodos ? now()->endOfMonth() : $mesFin;

        $totalVendido = Pedido::where('user_id', $userId)
            ->when(!$todosPeriodos, fn($q) => $q->whereBetween('created_at', [$mesInicio, $mesFin]))
            ->sum('precio_total');

        $totalComprado = CompraItem::whereHas('compra', fn($q) => $q
            ->when(!$todosPeriodos, fn($q2) => $q2->whereBetween('created_at', [$mesInicio, $mesFin])))
            ->sum('precio_total');

        $ganancia = $totalVendido - $totalComprado;

        $pedidosDisponibles = Pedido::where('user_id', $userId)
            ->where('estado_pedido', 'disponible')
            ->when(!$todosPeriodos, fn($q) => $q->whereBetween('created_at', [$mesInicio, $mesFin]))
            ->count();

        $pedidosEntregados = Pedido::where('user_id', $userId)
            ->where('estado_pedido', 'entregado')
            ->when(!$todosPeriodos, fn($q) => $q->whereBetween('created_at', [$mesInicio, $mesFin]))
            ->count();

        $pedidosPagados = Pedido::where('user_id', $userId)
            ->where('estado_pago', 'pagado')
            ->when(!$todosPeriodos, fn($q) => $q->whereBetween('created_at', [$mesInicio, $mesFin]))
            ->count();

        $pedidosNoPagados = Pedido::where('user_id', $userId)
            ->where('estado_pago', 'no_pagado')
            ->when(!$todosPeriodos, fn($q) => $q->whereBetween('created_at', [$mesInicio, $mesFin]))
            ->count();

        $ventasPorMes = Pedido::select('created_at', 'precio_total')
            ->where('user_id', $userId)
            ->whereBetween('created_at', [$graficoInicio, $graficoFin])
            ->get()
            ->groupBy(fn($p) => $p->created_at->format('Y-m'))
            ->map(fn($group, $key) => [
                'mes'   => Carbon::createFromFormat('Y-m', $key)->translatedFormat('M Y'),
                'total' => round($group->sum('precio_total'), 2),
            ])
            ->sortKeys()
            ->values();

        $comprasPorMes = CompraItem::whereHas('compra', fn($q) => $q->whereBetween('created_at', [$graficoInicio, $graficoFin]))
            ->with('compra:id,created_at')
            ->get()
            ->groupBy(fn($item) => $item->compra->created_at->format('Y-m'))
            ->map(fn($group, $key) => [
                'mes'   => Carbon::createFromFormat('Y-m', $key)->translatedFormat('M Y'),
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
            'comprasPorMes',
            'mes',
            'anio',
            'todosPeriodos'
        ));
    }
}
