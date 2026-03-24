<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
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
        return view('pedidos.create');
    }

    public function store(PedidoRequest $request)
    {
        Pedido::create($request->validated());
        return redirect()->route('pedidos.index')->with('success', 'Pedido cargado correctamente.');
    }

    public function show(Pedido $pedido)
    {
        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        return view('pedidos.edit', compact('pedido'));
    }

    public function update(PedidoRequest $request, Pedido $pedido)
    {
        $pedido->update($request->validated());
        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado correctamente.');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado correctamente.');
    }
}
