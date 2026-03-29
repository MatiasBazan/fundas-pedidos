<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Marca;
use App\Models\Modelo;
use App\Http\Requests\PedidoRequest;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $query = Pedido::query()
            ->when($request->estado_pedido, fn($q, $v) => $q->where('estado_pedido', $v))
            ->when($request->estado_pago,   fn($q, $v) => $q->where('estado_pago', $v))
            ->when($request->tipo_pago,     fn($q, $v) => $q->where('tipo_pago', $v));

        $total = $query->sum('precio');

        $pedidos = $query->latest()->paginate(20);

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

        // Manejar marca personalizada o del catálogo
        if ($request->filled('marca_otra')) {
            $marca = Marca::firstOrCreate(
                ['nombre' => $request->marca_otra],
                ['es_personalizada' => true]
            );
            $data['marca'] = $marca->nombre;
        } elseif ($request->filled('marca_id')) {
            $marca = Marca::find($request->marca_id);
            if ($marca) {
                $data['marca'] = $marca->nombre;
            } else {
                return back()->withErrors(['marca_id' => 'Marca no encontrada'])->withInput();
            }
        } else {
            return back()->withErrors(['marca_id' => 'Debe seleccionar o ingresar una marca'])->withInput();
        }

        // Manejar modelo personalizado o del catálogo
        if ($request->filled('modelo_otro')) {
            $modelo = Modelo::firstOrCreate(
                ['marca_id' => $marca->id, 'nombre' => $request->modelo_otro],
                ['es_personalizado' => true]
            );
            $data['modelo'] = $modelo->nombre;
        } elseif ($request->filled('modelo_id')) {
            $modelo = Modelo::find($request->modelo_id);
            if ($modelo) {
                $data['modelo'] = $modelo->nombre;
            } else {
                return back()->withErrors(['modelo_id' => 'Modelo no encontrado'])->withInput();
            }
        } else {
            return back()->withErrors(['modelo_id' => 'Debe seleccionar o ingresar un modelo'])->withInput();
        }

        if ($data['estado_pago'] === 'no_pagado') {
            $data['tipo_pago'] = null;
        }

        Pedido::create($data);
        return redirect()->route('pedidos.index')->with('success', 'Pedido cargado correctamente.');
    }

    public function show(Pedido $pedido)
    {
        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        $marcas = Marca::orderBy('nombre')->get();
        return view('pedidos.edit', compact('pedido', 'marcas'));
    }

    public function update(PedidoRequest $request, Pedido $pedido)
    {
        $data = $request->validated();

        // Manejar marca personalizada o del catálogo
        if ($request->filled('marca_otra')) {
            $marca = Marca::firstOrCreate(
                ['nombre' => $request->marca_otra],
                ['es_personalizada' => true]
            );
            $data['marca'] = $marca->nombre;
        } elseif ($request->filled('marca_id')) {
            $marca = Marca::find($request->marca_id);
            if ($marca) {
                $data['marca'] = $marca->nombre;
            } else {
                return back()->withErrors(['marca_id' => 'Marca no encontrada'])->withInput();
            }
        } else {
            return back()->withErrors(['marca_id' => 'Debe seleccionar o ingresar una marca'])->withInput();
        }

        // Manejar modelo personalizado o del catálogo
        if ($request->filled('modelo_otro')) {
            $modelo = Modelo::firstOrCreate(
                ['marca_id' => $marca->id, 'nombre' => $request->modelo_otro],
                ['es_personalizado' => true]
            );
            $data['modelo'] = $modelo->nombre;
        } elseif ($request->filled('modelo_id')) {
            $modelo = Modelo::find($request->modelo_id);
            if ($modelo) {
                $data['modelo'] = $modelo->nombre;
            } else {
                return back()->withErrors(['modelo_id' => 'Modelo no encontrado'])->withInput();
            }
        } else {
            return back()->withErrors(['modelo_id' => 'Debe seleccionar o ingresar un modelo'])->withInput();
        }

        if ($data['estado_pago'] === 'no_pagado') {
            $data['tipo_pago'] = null;
        }

        $pedido->update($data);
        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado correctamente.');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado correctamente.');
    }

    public function dashboard()
    {
        // Estadísticas generales
        $totalPedidos = Pedido::count();
        $totalIngresos = Pedido::where('estado_pago', 'pagado')->sum('precio');
        $pedidosPendientesPago = Pedido::where('estado_pago', 'no_pagado')->count();
        $montoPendiente = Pedido::where('estado_pago', 'no_pagado')->sum('precio');

        // Por estado de pedido
        $estadosPedido = Pedido::selectRaw('estado_pedido, COUNT(*) as cantidad, SUM(precio) as total')
            ->groupBy('estado_pedido')
            ->get();

        // Por estado de pago
        $estadosPago = Pedido::selectRaw('estado_pago, COUNT(*) as cantidad, SUM(precio) as total')
            ->groupBy('estado_pago')
            ->get();

        // Por tipo de pago
        $tiposPago = Pedido::selectRaw('tipo_pago, COUNT(*) as cantidad, SUM(precio) as total')
            ->whereNotNull('tipo_pago')
            ->groupBy('tipo_pago')
            ->get();

        // Marcas más vendidas
        $marcasTop = Pedido::selectRaw('marca, COUNT(*) as cantidad, SUM(precio) as total')
            ->groupBy('marca')
            ->orderByDesc('cantidad')
            ->limit(5)
            ->get();

        // Modelos más vendidos
        $modelosTop = Pedido::selectRaw('modelo, marca, COUNT(*) as cantidad, SUM(precio) as total')
            ->groupBy('modelo', 'marca')
            ->orderByDesc('cantidad')
            ->limit(5)
            ->get();

        // Pedidos por mes (últimos 6 meses)
        $pedidosPorMes = Pedido::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes, COUNT(*) as cantidad, SUM(precio) as total')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

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
