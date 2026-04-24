<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Http\Requests\PedidoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->applyFilters(Pedido::with('items'), $request);

        $total   = $query->sum('precio_total');
        $pedidos = $query->latest()->paginate(20)->withQueryString();

        return view('pedidos.index', compact('pedidos', 'total'));
    }

    public function create()
    {
        [$fondas, $accesorios] = $this->stockDisponibleSeparado();
        return view('pedidos.create', compact('fondas', 'accesorios'));
    }

    public function store(PedidoRequest $request)
    {
        $data = $request->validated();

        if ($data['estado_pago'] === 'no_pagado') {
            $data['tipo_pago'] = null;
        }

        // Agrupar por stock_id para validar stock suficiente
        $stockNeeds = collect($data['items'])
            ->groupBy('stock_id')
            ->map(fn($group) => $group->sum('cantidad'));

        foreach ($stockNeeds as $stockId => $needed) {
            $stock = Stock::findOrFail($stockId);
            if ($stock->cantidad < $needed) {
                return back()
                    ->withErrors(['items' => "Sin stock suficiente para \"{$stock->nombre_disenio}\" (disponible: {$stock->cantidad})."])
                    ->withInput();
            }
        }

        DB::transaction(function () use ($data) {
            $pedido = Pedido::create([
                'user_id'       => auth()->id(),
                'nombre'        => $data['nombre'],
                'apellido'      => $data['apellido'],
                'estado_pedido' => $data['estado_pedido'],
                'estado_pago'   => $data['estado_pago'],
                'tipo_pago'     => $data['tipo_pago'],
                'precio_total'  => 0,
            ]);

            $precioTotal = 0;

            foreach ($data['items'] as $itemData) {
                $stock    = Stock::findOrFail($itemData['stock_id']);
                $cantidad = (int) $itemData['cantidad'];
                $pu       = (float) $itemData['precio_unitario'];
                $subtotal = round($pu * $cantidad, 2);

                $pedido->items()->create([
                    'stock_id'        => $stock->id,
                    'modelo_celular'  => $stock->modelo_celular,
                    'nombre_disenio'  => $stock->nombre_disenio,
                    'categoria'       => $stock->categoria,
                    'cantidad'        => $cantidad,
                    'precio_unitario' => $pu,
                    'precio_total'    => $subtotal,
                ]);

                $cantidadAnterior = $stock->cantidad;
                $stock->decrement('cantidad', $cantidad);
                $stock->refresh();
                $this->registrarMovimiento($stock, 'venta', $cantidad, $cantidadAnterior, $stock->cantidad, 'pedido', $pedido->id);
                $precioTotal += $subtotal;
            }

            $this->invalidarCacheStock();
            $pedido->update(['precio_total' => round($precioTotal, 2)]);
        });

        return redirect()->route('pedidos.index')->with('success', 'Venta cargada correctamente.');
    }

    public function show(Pedido $pedido)
    {
        $this->authorize('view', $pedido);
        $pedido->load('items');
        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        $this->authorize('view', $pedido);

        $pedido->load('items');
        $usedStockIds = $pedido->items->pluck('stock_id')->filter()->values()->toArray();

        [$fondas, $accesorios] = $this->stockDisponibleSeparado($usedStockIds);

        $itemsInit = $pedido->items->map(fn($i) => [
            'stock_id'        => $i->stock_id,
            'cantidad'        => $i->cantidad,
            'precio_unitario' => $i->precio_unitario,
        ])->values()->toArray();

        return view('pedidos.edit', compact('pedido', 'fondas', 'accesorios', 'itemsInit'));
    }

    public function update(PedidoRequest $request, Pedido $pedido)
    {
        $this->authorize('update', $pedido);

        $data = $request->validated();

        if ($data['estado_pago'] === 'no_pagado') {
            $data['tipo_pago'] = null;
        }

        $pedido->load('items');

        // Validar stock para los nuevos items (descontando lo que ya usa este pedido)
        $stockNeeds = collect($data['items'])
            ->groupBy('stock_id')
            ->map(fn($group) => $group->sum('cantidad'));

        $currentAllocation = $pedido->items
            ->whereNotNull('stock_id')
            ->groupBy('stock_id')
            ->map(fn($group) => $group->sum('cantidad'));

        foreach ($stockNeeds as $stockId => $needed) {
            $stock     = Stock::findOrFail($stockId);
            $available = $stock->cantidad + ($currentAllocation[$stockId] ?? 0);
            if ($available < $needed) {
                return back()
                    ->withErrors(['items' => "Sin stock suficiente para \"{$stock->nombre_disenio}\" (disponible: {$available})."])
                    ->withInput();
            }
        }

        DB::transaction(function () use ($data, $pedido) {
            // Devolver stock de items actuales
            foreach ($pedido->items as $item) {
                if ($item->stock_id) {
                    $stock = Stock::find($item->stock_id);
                    if ($stock) {
                        $cantidadAnterior = $stock->cantidad;
                        $stock->increment('cantidad', $item->cantidad);
                        $stock->refresh();
                        $this->registrarMovimiento($stock, 'venta_cancelada', $item->cantidad, $cantidadAnterior, $stock->cantidad, 'pedido', $pedido->id);
                    }
                }
            }

            $pedido->items()->delete();

            $precioTotal = 0;

            foreach ($data['items'] as $itemData) {
                $stock    = Stock::findOrFail($itemData['stock_id']);
                $cantidad = (int) $itemData['cantidad'];
                $pu       = (float) $itemData['precio_unitario'];
                $subtotal = round($pu * $cantidad, 2);

                $pedido->items()->create([
                    'stock_id'        => $stock->id,
                    'modelo_celular'  => $stock->modelo_celular,
                    'nombre_disenio'  => $stock->nombre_disenio,
                    'categoria'       => $stock->categoria,
                    'cantidad'        => $cantidad,
                    'precio_unitario' => $pu,
                    'precio_total'    => $subtotal,
                ]);

                $cantidadAnterior = $stock->cantidad;
                $stock->decrement('cantidad', $cantidad);
                $stock->refresh();
                $this->registrarMovimiento($stock, 'venta', $cantidad, $cantidadAnterior, $stock->cantidad, 'pedido', $pedido->id);
                $precioTotal += $subtotal;
            }

            $pedido->update([
                'nombre'        => $data['nombre'],
                'apellido'      => $data['apellido'],
                'estado_pedido' => $data['estado_pedido'],
                'estado_pago'   => $data['estado_pago'],
                'tipo_pago'     => $data['tipo_pago'],
                'precio_total'  => round($precioTotal, 2),
            ]);
            $this->invalidarCacheStock();
        });

        return redirect()->route('pedidos.index')->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy(Pedido $pedido)
    {
        $this->authorize('delete', $pedido);

        $pedido->load('items');

        DB::transaction(function () use ($pedido) {
            foreach ($pedido->items as $item) {
                if ($item->stock_id) {
                    $stock = Stock::find($item->stock_id);
                    if ($stock) {
                        $cantidadAnterior = $stock->cantidad;
                        $stock->increment('cantidad', $item->cantidad);
                        $stock->refresh();
                        $this->registrarMovimiento($stock, 'venta_cancelada', $item->cantidad, $cantidadAnterior, $stock->cantidad, 'pedido', $pedido->id);
                    }
                }
            }
            $pedido->items()->delete();
            $pedido->delete();
            $this->invalidarCacheStock();
        });

        return redirect()->route('pedidos.index')->with('success', 'Venta eliminada correctamente.');
    }

    public function exportCsv(Request $request)
    {
        $pedidos = $this->applyFilters(Pedido::with('items'), $request)->latest()->get();

        $filename = 'pedidos_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($pedidos) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, ['ID', 'Productos', 'Nombre', 'Apellido', 'Total', 'Estado Pedido', 'Estado Pago', 'Tipo Pago', 'Fecha']);

            foreach ($pedidos as $pedido) {
                $productos = $pedido->items->map(fn($i) =>
                    ($i->modelo_celular ? "{$i->modelo_celular} - " : '') . "{$i->nombre_disenio} x{$i->cantidad}"
                )->implode(', ');

                fputcsv($handle, [
                    $pedido->id,
                    $productos,
                    $pedido->nombre,
                    $pedido->apellido,
                    $pedido->precio_total,
                    $pedido->estado_pedido,
                    $pedido->estado_pago,
                    $pedido->tipo_pago ?? '',
                    $pedido->created_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function stockDisponibleSeparado(array $includeStockIds = []): array
    {
        $cacheKey = 'stock_disponible_' . (empty($includeStockIds) ? 'all' : implode('_', $includeStockIds));

        return Cache::remember($cacheKey, now()->addMinutes(1), function () use ($includeStockIds) {
            $base = Stock::query()
                ->where(fn($q) => $q
                    ->where('cantidad', '>', 0)
                    ->when($includeStockIds, fn($q) => $q->orWhereIn('id', $includeStockIds))
                );

            $fondas = (clone $base)
                ->where('categoria', 'funda')
                ->orderBy('modelo_celular')
                ->orderBy('nombre_disenio')
                ->get();

            $accesorios = (clone $base)
                ->where('categoria', 'accesorio')
                ->orderBy('nombre_disenio')
                ->get();

            return [$fondas, $accesorios];
        });
    }

    private function applyFilters(\Illuminate\Database\Eloquent\Builder $query, Request $request): \Illuminate\Database\Eloquent\Builder
    {
        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        return $query
            ->when($request->estado_pedido, fn($q, $v) => $q->where('estado_pedido', $v))
            ->when($request->estado_pago,   fn($q, $v) => $q->where('estado_pago', $v))
            ->when($request->tipo_pago,     fn($q, $v) => $q->where('tipo_pago', $v))
            ->when($request->buscar,        fn($q, $v) => $q->where(function ($q) use ($v) {
                $buscar = addcslashes($v, '%_');
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('apellido', 'like', "%{$buscar}%")
                  ->orWhereHas('items', fn($qi) => $qi
                      ->where('nombre_disenio', 'like', "%{$buscar}%")
                      ->orWhere('modelo_celular', 'like', "%{$buscar}%")
                  );
            }));
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

private function invalidarCacheStock(): void
    {
        Cache::forget('stock_disponible_all');
    }

    public function dashboard()
    {
        $userId = auth()->id();

        $totalPedidos          = Pedido::where('user_id', $userId)->count();
        $totalIngresos         = Pedido::where('user_id', $userId)->where('estado_pago', 'pagado')->sum('precio_total');
        $pedidosPendientesPago = Pedido::where('user_id', $userId)->where('estado_pago', 'no_pagado')->count();
        $montoPendiente        = Pedido::where('user_id', $userId)->where('estado_pago', 'no_pagado')->sum('precio_total');

        $estadosPedido = Pedido::selectRaw('estado_pedido, COUNT(*) as cantidad, SUM(precio_total) as total')
            ->where('user_id', $userId)
            ->groupBy('estado_pedido')
            ->get();

        $estadosPago = Pedido::selectRaw('estado_pago, COUNT(*) as cantidad, SUM(precio_total) as total')
            ->where('user_id', $userId)
            ->groupBy('estado_pago')
            ->get();

        $tiposPago = Pedido::selectRaw('tipo_pago, COUNT(*) as cantidad, SUM(precio_total) as total')
            ->where('user_id', $userId)
            ->whereNotNull('tipo_pago')
            ->groupBy('tipo_pago')
            ->get();

        $marcasTop = PedidoItem::selectRaw('modelo_celular, COUNT(*) as cantidad, SUM(precio_total) as total')
            ->whereHas('pedido', fn($q) => $q->where('user_id', $userId))
            ->where('categoria', 'funda')
            ->whereNotNull('modelo_celular')
            ->groupBy('modelo_celular')
            ->orderByDesc('cantidad')
            ->limit(5)
            ->get();

        $modelosTop = PedidoItem::selectRaw('nombre_disenio, modelo_celular, COUNT(*) as cantidad, SUM(precio_total) as total')
            ->whereHas('pedido', fn($q) => $q->where('user_id', $userId))
            ->whereNotNull('nombre_disenio')
            ->groupBy('nombre_disenio', 'modelo_celular')
            ->orderByDesc('cantidad')
            ->limit(5)
            ->get();

        $pedidosPorMes = Pedido::select('created_at', 'precio_total')
            ->where('user_id', $userId)
            ->where('created_at', '>=', now()->subMonths(6))
            ->get()
            ->groupBy(fn($p) => $p->created_at->format('Y-m'))
            ->map(fn($group, $mes) => [
                'mes'      => $mes,
                'cantidad' => $group->count(),
                'total'    => $group->sum('precio_total'),
            ])
            ->sortKeys()
            ->values();

        return view('pedidos.dashboard', compact(
            'totalPedidos',
            'totalIngresos',
            'pedidosPendientesPago',
            'montoPendiente',
            'estadosPedido',
            'estadosPago',
            'tiposPago',
            'marcasTop',
            'modelosTop',
            'pedidosPorMes'
        ));
    }
}
