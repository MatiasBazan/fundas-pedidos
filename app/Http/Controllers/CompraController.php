<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\CompraItem;
use App\Models\Marca;
use App\Models\Modelo;
use App\Http\Requests\CompraRequest;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index(Request $request)
    {
        $itemQuery = CompraItem::query()
            ->when($request->modelo_celular, fn($q, $v) => $q->where('modelo_celular', 'like', "%{$v}%"))
            ->when($request->nombre_disenio,  fn($q, $v) => $q->where('nombre_disenio',  'like', "%{$v}%"));

        $totalUnidades  = (clone $itemQuery)->sum('cantidad');
        $totalInvertido = (clone $itemQuery)->sum('precio_total');

        $comprasQuery = Compra::withCount('items')
            ->withSum('items', 'cantidad')
            ->withSum('items', 'precio_total');

        if ($request->modelo_celular) {
            $comprasQuery->whereHas('items', fn($q) => $q->where('modelo_celular', 'like', "%{$request->modelo_celular}%"));
        }
        if ($request->nombre_disenio) {
            $comprasQuery->whereHas('items', fn($q) => $q->where('nombre_disenio', 'like', "%{$request->nombre_disenio}%"));
        }

        $compras = $comprasQuery->latest()->paginate(20)->withQueryString();

        return view('compras.index', compact('compras', 'totalUnidades', 'totalInvertido'));
    }

    public function create()
    {
        $marcas          = Marca::orderBy('nombre')->get();
        $modelosPorMarca = $this->getModelosPorMarca();

        return view('compras.create', compact('marcas', 'modelosPorMarca'));
    }

    public function store(CompraRequest $request)
    {
        $compra = Compra::create([
            'fecha'        => $request->fecha,
            'observaciones' => $request->observaciones,
        ]);

        foreach ($request->input('items', []) as $itemData) {
            [$marca, $modelo] = $this->resolveItemDependencias($itemData);

            CompraItem::create([
                'compra_id'       => $compra->id,
                'marca_id'        => $marca->id,
                'modelo_id'       => $modelo->id,
                'modelo_celular'  => $marca->nombre . ' ' . $modelo->nombre,
                'nombre_disenio'  => $itemData['nombre_disenio'],
                'cantidad'        => $itemData['cantidad'],
                'precio_unitario' => $itemData['precio_unitario'],
                'precio_total'    => $itemData['cantidad'] * $itemData['precio_unitario'],
            ]);
        }

        return redirect()->route('compras.index')->with('success', 'Compra registrada correctamente.');
    }

    public function show(Compra $compra)
    {
        $compra->load('items');
        return view('compras.show', compact('compra'));
    }

    public function edit(Compra $compra)
    {
        $compra->load('items');
        $marcas          = Marca::orderBy('nombre')->get();
        $modelosPorMarca = $this->getModelosPorMarca();

        $itemsInit = $compra->items->map(fn($item) => [
            'marcaId'        => (string)($item->marca_id ?? ''),
            'showNuevaMarca' => false,
            'marcaNueva'     => '',
            'modeloId'       => (string)($item->modelo_id ?? ''),
            'showNuevoModelo'=> false,
            'modeloNuevo'    => '',
            'nombreDisenio'  => $item->nombre_disenio,
            'cantidad'       => (string)$item->cantidad,
            'precioUnitario' => (string)$item->precio_unitario,
        ])->values()->toArray();

        return view('compras.edit', compact('compra', 'marcas', 'modelosPorMarca', 'itemsInit'));
    }

    public function update(CompraRequest $request, Compra $compra)
    {
        $compra->update([
            'fecha'        => $request->fecha,
            'observaciones' => $request->observaciones,
        ]);

        // Delete existing items — observer decrements stock for each
        $compra->items->each->delete();

        // Create new items — observer increments stock for each
        foreach ($request->input('items', []) as $itemData) {
            [$marca, $modelo] = $this->resolveItemDependencias($itemData);

            CompraItem::create([
                'compra_id'       => $compra->id,
                'marca_id'        => $marca->id,
                'modelo_id'       => $modelo->id,
                'modelo_celular'  => $marca->nombre . ' ' . $modelo->nombre,
                'nombre_disenio'  => $itemData['nombre_disenio'],
                'cantidad'        => $itemData['cantidad'],
                'precio_unitario' => $itemData['precio_unitario'],
                'precio_total'    => $itemData['cantidad'] * $itemData['precio_unitario'],
            ]);
        }

        return redirect()->route('compras.index')->with('success', 'Compra actualizada correctamente.');
    }

    public function destroy(Compra $compra)
    {
        // Delete items individually so observer fires for each
        $compra->items->each->delete();
        $compra->delete();

        return redirect()->route('compras.index')->with('success', 'Compra eliminada correctamente.');
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    private function resolveItemDependencias(array $item): array
    {
        if (!empty($item['marca_nueva'])) {
            $marca = Marca::firstOrCreate(['nombre' => trim($item['marca_nueva'])]);
        } else {
            $marca = Marca::findOrFail($item['marca_id']);
        }

        if (!empty($item['modelo_nuevo'])) {
            $modelo = Modelo::firstOrCreate([
                'marca_id' => $marca->id,
                'nombre'   => trim($item['modelo_nuevo']),
            ]);
        } else {
            $modelo = Modelo::findOrFail($item['modelo_id']);
        }

        return [$marca, $modelo];
    }

    private function getModelosPorMarca(): array
    {
        return Modelo::orderBy('nombre')
            ->get()
            ->groupBy('marca_id')
            ->map(fn($g) => $g->map(fn($m) => ['id' => $m->id, 'nombre' => $m->nombre])->values())
            ->toArray();
    }
}
