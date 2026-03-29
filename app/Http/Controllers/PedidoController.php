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
}
