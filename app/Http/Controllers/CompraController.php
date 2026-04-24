<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\CompraItem;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\PedidoItem;
use App\Models\Stock;
use App\Http\Requests\CompraRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompraController extends Controller
{
    public function index(Request $request)
    {
        $buscarModelo = $request->modelo_celular ? addcslashes($request->modelo_celular, '%_') : null;
        $buscarDisenio = $request->nombre_disenio ? addcslashes($request->nombre_disenio, '%_') : null;

        $itemQuery = CompraItem::query()
            ->when($buscarModelo, fn($q, $v) => $q->where('modelo_celular', 'like', "%{$v}%"))
            ->when($buscarDisenio,  fn($q, $v) => $q->where('nombre_disenio',  'like', "%{$v}%"));

        $totalUnidades  = (clone $itemQuery)->sum('cantidad');
        $totalInvertido = (clone $itemQuery)->sum('precio_total');

        $comprasQuery = Compra::withCount('items')
            ->withSum('items', 'cantidad')
            ->withSum('items', 'precio_total');

        if ($buscarModelo) {
            $comprasQuery->whereHas('items', fn($q) => $q->where('modelo_celular', 'like', "%{$buscarModelo}%"));
        }
        if ($buscarDisenio) {
            $comprasQuery->whereHas('items', fn($q) => $q->where('nombre_disenio', 'like', "%{$buscarDisenio}%"));
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
        Log::info('CompraController@store - inicio', [
            'fecha'        => $request->fecha,
            'observaciones' => $request->observaciones,
            'items'        => $request->input('items', []),
        ]);

        $compra = DB::transaction(function () use ($request) {
            $compra = Compra::create([
                'fecha'        => $request->fecha,
                'observaciones' => $request->observaciones,
            ]);

            foreach ($request->input('items', []) as $itemData) {
                $this->crearItem($compra->id, $itemData);
            }

            return $compra;
        });

        Log::info('CompraController@store - guardado OK', ['compra_id' => $compra->id]);

        return redirect()->route('compras.index')->with('success', 'Compra registrada correctamente.');
    }

    public function show(Compra $compra)
    {
        $compra->load('items');

        $keys = $compra->items->map(fn($i) => ['modelo' => $i->modelo_celular, 'disenio' => $i->nombre_disenio])->toArray();

        $ventasPorItem = [];
        if (!empty($keys)) {
            $ventas = PedidoItem::where(function ($q) use ($keys) {
                foreach ($keys as $key) {
                    $q->orWhere(fn($sq) => $sq
                        ->where('modelo_celular', $key['modelo'])
                        ->where('nombre_disenio', $key['disenio'])
                    );
                }
            })->get();

            foreach ($keys as $key) {
                $ventasPorItem["{$key['modelo']}|{$key['disenio']}"] = $ventas
                    ->where('modelo_celular', $key['modelo'])
                    ->where('nombre_disenio', $key['disenio']);
            }
        }

        $rentabilidad = [];
        foreach ($compra->items as $item) {
            $key = "{$item->modelo_celular}|{$item->nombre_disenio}";
            $ventas = $ventasPorItem[$key] ?? collect();

            $cantidadVendida  = $ventas->sum('cantidad');
            $ingresosGenerados = $ventas->sum('precio_total');
            $costoItem        = $item->precio_total;
            $gananciaItem     = $ingresosGenerados - $costoItem;
            $margenItem       = $costoItem > 0 ? ($gananciaItem / $costoItem) * 100 : 0;
            $porcentajeVendido = $item->cantidad > 0 ? min(($cantidadVendida / $item->cantidad) * 100, 100) : 0;

            $rentabilidad[$item->id] = [
                'cantidad_vendida'   => $cantidadVendida,
                'unidades_restantes' => $item->cantidad - $cantidadVendida,
                'ingresos_generados' => $ingresosGenerados,
                'costo_item'         => $costoItem,
                'ganancia_item'      => $gananciaItem,
                'margen_item'        => $margenItem,
                'porcentaje_vendido' => $porcentajeVendido,
            ];
        }

        $totalInvertido = $compra->items->sum('precio_total');
        $totalIngresos  = array_sum(array_column($rentabilidad, 'ingresos_generados'));
        $gananciTotal   = $totalIngresos - $totalInvertido;
        $margenTotal    = $totalInvertido > 0 ? ($gananciTotal / $totalInvertido) * 100 : 0;

        $totalesRentabilidad = [
            'total_invertido' => $totalInvertido,
            'total_ingresos'  => $totalIngresos,
            'ganancia_total'  => $gananciTotal,
            'margen_total'    => $margenTotal,
        ];

        return view('compras.show', compact('compra', 'rentabilidad', 'totalesRentabilidad'));
    }

    public function edit(Compra $compra)
    {
        $compra->load('items');
        $marcas          = Marca::orderBy('nombre')->get();
        $modelosPorMarca = $this->getModelosPorMarca();

        $itemsInit = $compra->items->map(fn($item) => [
            'categoria'      => $item->categoria ?? 'funda',
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
        $compra->load('items');

        foreach ($compra->items as $item) {
            $stock = Stock::where('categoria', $item->categoria)
                ->where('modelo_celular', $item->modelo_celular)
                ->where('nombre_disenio', $item->nombre_disenio)
                ->first();

            if ($stock && $stock->cantidad < $item->cantidad) {
                return back()->withErrors(['compra' => "No se puede actualizar: el producto \"{$item->nombre_disenio}\" ya fue vendido y no hay stock suficiente para devolver."]);
            }
        }

        DB::transaction(function () use ($request, $compra) {
            $compra->update([
                'fecha'        => $request->fecha,
                'observaciones' => $request->observaciones,
            ]);

            $compra->items->each->delete();

            foreach ($request->input('items', []) as $itemData) {
                $this->crearItem($compra->id, $itemData);
            }
        });

        return redirect()->route('compras.index')->with('success', 'Compra actualizada correctamente.');
    }

    public function destroy(Compra $compra)
    {
        $compra->load('items');

        foreach ($compra->items as $item) {
            $stock = Stock::where('categoria', $item->categoria)
                ->where('modelo_celular', $item->modelo_celular)
                ->where('nombre_disenio', $item->nombre_disenio)
                ->first();

            if ($stock && $stock->cantidad < $item->cantidad) {
                return back()->withErrors(['compra' => "No se puede eliminar: el producto \"{$item->nombre_disenio}\" ya fue vendido y no hay stock suficiente para devolver."]);
            }
        }

        $compra->items->each->delete();
        $compra->delete();

        return redirect()->route('compras.index')->with('success', 'Compra eliminada correctamente.');
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    private function crearItem(int $compraId, array $itemData): void
    {
        $categoria = $itemData['categoria'] ?? 'funda';

        if ($categoria === 'accesorio') {
            CompraItem::create([
                'compra_id'       => $compraId,
                'categoria'       => 'accesorio',
                'marca_id'        => null,
                'modelo_id'       => null,
                'modelo_celular'  => 'Accesorio',
                'nombre_disenio'  => $itemData['nombre_disenio'],
                'cantidad'        => $itemData['cantidad'],
                'precio_unitario' => $itemData['precio_unitario'],
                'precio_total'    => $itemData['cantidad'] * $itemData['precio_unitario'],
            ]);
            return;
        }

        [$marca, $modelo] = $this->resolveItemDependencias($itemData);

        CompraItem::create([
            'compra_id'       => $compraId,
            'categoria'       => 'funda',
            'marca_id'        => $marca->id,
            'modelo_id'       => $modelo->id,
            'modelo_celular'  => $marca->nombre . ' ' . $modelo->nombre,
            'nombre_disenio'  => $itemData['nombre_disenio'],
            'cantidad'        => $itemData['cantidad'],
            'precio_unitario' => $itemData['precio_unitario'],
            'precio_total'    => $itemData['cantidad'] * $itemData['precio_unitario'],
        ]);
    }

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
