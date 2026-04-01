<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Marca;
use App\Models\Modelo;
use App\Http\Requests\PedidoRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $query = Pedido::query()
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

        $total = $query->sum('precio');
        $pedidos = $query->latest()->paginate(20)->withQueryString();

        return view('pedidos.index', compact('pedidos', 'total'));
    }

    public function create()
    {
        $marcas = Marca::orderBy('nombre')->get();
        return view('pedidos.create', compact('marcas'));
    }

    public function getModelos($marcaId)
    {
        $modelos = Modelo::where('marca_id', $marcaId)
            ->orderBy('nombre')
            ->get();

        return response()->json($modelos);
    }

    public function store(PedidoRequest $request)
    {
        $data = $request->validated();

        if ($redirect = $this->resolveMarcaModelo($request, $data)) {
            return $redirect;
        }

        if ($data['estado_pago'] === 'no_pagado') {
            $data['tipo_pago'] = null;
        }

        $data['user_id'] = auth()->id();
        Pedido::create($data);
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
        $marcas = Marca::orderBy('nombre')->get();
        return view('pedidos.edit', compact('pedido', 'marcas'));
    }

    public function update(PedidoRequest $request, Pedido $pedido)
    {
        abort_if($pedido->user_id !== auth()->id(), 403);
        $data = $request->validated();

        if ($redirect = $this->resolveMarcaModelo($request, $data)) {
            return $redirect;
        }

        if ($data['estado_pago'] === 'no_pagado') {
            $data['tipo_pago'] = null;
        }

        $pedido->update($data);
        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado correctamente.');
    }

    public function destroy(Pedido $pedido)
    {
        abort_if($pedido->user_id !== auth()->id(), 403);
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado correctamente.');
    }

    public function exportCsv(Request $request)
    {
        $pedidos = Pedido::query()
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
            }))
            ->latest()
            ->get();

        $filename = 'pedidos_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($pedidos) {
            $handle = fopen('php://output', 'w');
            // BOM para compatibilidad con Excel
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, ['ID', 'Diseño', 'Marca', 'Modelo', 'Nombre', 'Apellido', 'Precio', 'Estado Pedido', 'Estado Pago', 'Tipo Pago', 'Fecha']);

            foreach ($pedidos as $pedido) {
                fputcsv($handle, [
                    $pedido->id,
                    $pedido->nombre_disenio,
                    $pedido->marca,
                    $pedido->modelo,
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

        // Compatibilidad con cualquier motor de BD: agrupado en PHP
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

    private function resolveMarcaModelo(Request $request, array &$data): ?RedirectResponse
    {
        // Resolver marca
        if ($request->filled('marca_otra')) {
            $marca = Marca::firstOrCreate(
                ['nombre' => $request->marca_otra],
                ['es_personalizada' => true]
            );
            $data['marca']    = $marca->nombre;
            $data['marca_id'] = $marca->id;
        } elseif ($request->filled('marca_id')) {
            $marca = Marca::find($request->marca_id);
            if (!$marca) {
                return back()->withErrors(['marca_id' => 'Marca no encontrada'])->withInput();
            }
            $data['marca']    = $marca->nombre;
            $data['marca_id'] = $marca->id;
        } else {
            return back()->withErrors(['marca_id' => 'Debe seleccionar o ingresar una marca'])->withInput();
        }

        // Resolver modelo
        if ($request->filled('modelo_otro')) {
            $modelo = Modelo::firstOrCreate(
                ['marca_id' => $marca->id, 'nombre' => $request->modelo_otro],
                ['es_personalizado' => true]
            );
            $data['modelo']    = $modelo->nombre;
            $data['modelo_id'] = $modelo->id;
        } elseif ($request->filled('modelo_id')) {
            $modelo = Modelo::find($request->modelo_id);
            if (!$modelo) {
                return back()->withErrors(['modelo_id' => 'Modelo no encontrado'])->withInput();
            }
            $data['modelo']    = $modelo->nombre;
            $data['modelo_id'] = $modelo->id;
        } else {
            return back()->withErrors(['modelo_id' => 'Debe seleccionar o ingresar un modelo'])->withInput();
        }

        return null;
    }
}
