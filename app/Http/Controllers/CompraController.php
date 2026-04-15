<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Http\Requests\CompraRequest;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index(Request $request)
    {
        $query = Compra::query()
            ->when($request->modelo_celular, fn($q, $v) => $q->where('modelo_celular', 'like', "%{$v}%"))
            ->when($request->nombre_disenio, fn($q, $v) => $q->where('nombre_disenio', 'like', "%{$v}%"));

        $totalUnidades = (clone $query)->sum('cantidad');
        $totalInvertido = (clone $query)->sum('precio_total');
        $compras = $query->latest()->paginate(20)->withQueryString();

        return view('compras.index', compact('compras', 'totalUnidades', 'totalInvertido'));
    }

    public function create()
    {
        return view('compras.create');
    }

    public function store(CompraRequest $request)
    {
        $data = $request->validated();
        $data['precio_total'] = $data['cantidad'] * $data['precio_unitario'];

        Compra::create($data);

        return redirect()->route('compras.index')->with('success', 'Compra registrada correctamente.');
    }

    public function show(Compra $compra)
    {
        return view('compras.show', compact('compra'));
    }

    public function edit(Compra $compra)
    {
        return view('compras.edit', compact('compra'));
    }

    public function update(CompraRequest $request, Compra $compra)
    {
        $data = $request->validated();
        $data['precio_total'] = $data['cantidad'] * $data['precio_unitario'];

        $compra->update($data);

        return redirect()->route('compras.index')->with('success', 'Compra actualizada correctamente.');
    }

    public function destroy(Compra $compra)
    {
        $compra->delete();

        return redirect()->route('compras.index')->with('success', 'Compra eliminada correctamente.');
    }
}
