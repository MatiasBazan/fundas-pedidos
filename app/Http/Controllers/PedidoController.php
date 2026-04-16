<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Stock;
use App\Http\Requests\PedidoRequest;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->applyFilters(Pedido::query(), $request);

        $total   = $query->sum('precio');
        $pedidos = $query->latest()->paginate(20)->withQueryString();

        return view('pedidos.index', compact('pedidos', 'total'));
    }

    public function create()
    {
        $stockDisponible = Stock::where('cantidad', '>', 0)->orderBy('modelo_celular')->get();
        return view('pedidos.create', compact('stockDisponible'));
    }

    public function store(PedidoRequest $request)
    {
        $data = $request->validated();

        $stock = Stock::findOrFail($data['stock_id']);

        if ($stock->cantidad < 1) {
            return back()->withErrors(['stock_id' => 'No hay unidades disponibles de este producto.'])->withInput();
        }

        $data['nombre_disenio'] = $stock->nombre_disenio;
        $data['marca']          = $stock->modelo_celular;
        $data['modelo']         = '';
        $data['marca_id']       = null;
        $data['modelo_id']      = null;

        if ($data['estado_pago'] === 'no_pagado') {
            $data['tipo_pago'] = null;
        }

        $data['user_id'] = auth()->id();
        Pedido::create($data);
        $stock->decrement('cantidad');

        return redirect()->route('pedidos.index')->with('success', 'Pedido cargado correctamente.');
    }

    public function show(Pedido $pedido)
    {
        abort_if($pedido->user_id !== auth()->id(), 403);
        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        abort_if($pedido->user_id !== auth()->id(), 403);

        $stockDisponible = Stock::where('cantidad', '>', 0)
            ->when($pedido->stock_id, fn($q) => $q->orWhere('id', $pedido->stock_id))
            ->orderBy('modelo_celular')
            ->get();

        return view('pedidos.edit', compact('pedido', 'stockDisponible'));
    }

    public function update(PedidoRequest $request, Pedido $pedido)
    {
        abort_if($pedido->user_id !== auth()->id(), 403);

        $data = $request->validated();
        $newStockId = (int) $data['stock_id'];
        $oldStockId = $pedido->stock_id;

        $newStock = Stock::findOrFail($newStockId);

        if ($oldStockId !== $newStockId) {
            if ($newStock->cantidad < 1) {
                return back()->withErrors(['stock_id' => 'No hay unidades disponibles de este producto.'])->withInput();
            }
            if ($oldStockId) {
                Stock::find($oldStockId)?->increment('cantidad');
            }
            $newStock->decrement('cantidad');
        }

        $data['nombre_disenio'] = $newStock->nombre_disenio;
        $data['marca']          = $newStock->modelo_celular;
        $data['modelo']         = '';
        $data['marca_id']       = null;
        $data['modelo_id']      = null;

        if ($data['estado_pago'] === 'no_pagado') {
            $data['tipo_pago'] = null;
        }

        $pedido->update($data);
        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado correctamente.');
    }

    public function destroy(Pedido $pedido)
    {
        abort_if($pedido->user_id !== auth()->id(), 403);

        if ($pedido->stock_id) {
            Stock::find($pedido->stock_id)?->increment('cantidad');
        }

        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado correctamente.');
    }

    public function exportCsv(Request $request)
    {
        $pedidos = $this->applyFilters(Pedido::query(), $request)->latest()->get();

        $filename = 'pedidos_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($pedidos) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, ['ID', 'Producto', 'Diseño', 'Nombre', 'Apellido', 'Precio', 'Estado Pedido', 'Estado Pago', 'Tipo Pago', 'Fecha']);

            foreach ($pedidos as $pedido) {
                fputcsv($handle, [
                    $pedido->id,
                    $pedido->marca,
                    $pedido->nombre_disenio,
                    $pedido->nombre,
                    $pedido->apellido,
                    $pedido->precio,
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

    private function applyFilters(\Illuminate\Database\Eloquent\Builder $query, Request $request): \Illuminate\Database\Eloquent\Builder
    {
        return $query
            ->where('user_id', auth()->id())
            ->when($request->estado_pedido, fn($q, $v) => $q->where('estado_pedido', $v))
            ->when($request->estado_pago,   fn($q, $v) => $q->where('estado_pago', $v))
            ->when($request->tipo_pago,     fn($q, $v) => $q->where('tipo_pago', $v))
            ->when($request->buscar,        fn($q, $v) => $q->where(function ($q) use ($v) {
                $q->where('nombre', 'like', "%{$v}%")
                  ->orWhere('apellido', 'like', "%{$v}%")
                  ->orWhere('nombre_disenio', 'like', "%{$v}%")
                  ->orWhere('marca', 'like', "%{$v}%")
                  ->orWhere('modelo', 'like', "%{$v}%");
            }));
    }

    public function dashboard()
    {
        $userId = auth()->id();

        $totalPedidos          = Pedido::where('user_id', $userId)->count();
        $totalIngresos         = Pedido::where('user_id', $userId)->where('estado_pago', 'pagado')->sum('precio');
        $pedidosPendientesPago = Pedido::where('user_id', $userId)->where('estado_pago', 'no_pagado')->count();
        $montoPendiente        = Pedido::where('user_id', $userId)->where('estado_pago', 'no_pagado')->sum('precio');

        $estadosPedido = Pedido::selectRaw('estado_pedido, COUNT(*) as cantidad, SUM(precio) as total')
            ->where('user_id', $userId)
            ->groupBy('estado_pedido')
            ->get();

        $estadosPago = Pedido::selectRaw('estado_pago, COUNT(*) as cantidad, SUM(precio) as total')
            ->where('user_id', $userId)
            ->groupBy('estado_pago')
            ->get();

        $tiposPago = Pedido::selectRaw('tipo_pago, COUNT(*) as cantidad, SUM(precio) as total')
            ->where('user_id', $userId)
            ->whereNotNull('tipo_pago')
            ->groupBy('tipo_pago')
            ->get();

        $marcasTop = Pedido::selectRaw('marca, COUNT(*) as cantidad, SUM(precio) as total')
            ->where('user_id', $userId)
            ->groupBy('marca')
            ->orderByDesc('cantidad')
            ->limit(5)
            ->get();

        $modelosTop = Pedido::selectRaw('modelo, marca, COUNT(*) as cantidad, SUM(precio) as total')
            ->where('user_id', $userId)
            ->groupBy('modelo', 'marca')
            ->orderByDesc('cantidad')
            ->limit(5)
            ->get();

        $pedidosPorMes = Pedido::select('created_at', 'precio')
            ->where('user_id', $userId)
            ->where('created_at', '>=', now()->subMonths(6))
            ->get()
            ->groupBy(fn($p) => $p->created_at->format('Y-m'))
            ->map(fn($group, $mes) => [
                'mes'      => $mes,
                'cantidad' => $group->count(),
                'total'    => $group->sum('precio'),
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
