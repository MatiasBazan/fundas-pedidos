<?php

namespace Tests\Feature;

use App\Models\Compra;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Pedido;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_compra_incrementa_stock(): void
    {
        $marca  = Marca::factory()->create(['nombre' => 'Samsung']);
        $modelo = Modelo::factory()->create(['marca_id' => $marca->id, 'nombre' => 'Galaxy A54']);

        $this->actingAs($this->admin)
            ->post(route('compras.store'), [
                'fecha' => '2026-04-16',
                'items' => [[
                    'categoria'       => 'funda',
                    'marca_id'        => $marca->id,
                    'modelo_id'       => $modelo->id,
                    'nombre_disenio'  => 'Flores rosas',
                    'cantidad'        => 5,
                    'precio_unitario' => 200,
                ]],
            ])
            ->assertRedirect(route('compras.index'));

        $this->assertDatabaseHas('stocks', [
            'modelo_celular' => 'Samsung Galaxy A54',
            'nombre_disenio' => 'Flores Rosas',
            'cantidad'       => 5,
        ]);
    }

    public function test_eliminar_compra_decrementa_stock(): void
    {
        $marca  = Marca::factory()->create(['nombre' => 'Apple']);
        $modelo = Modelo::factory()->create(['marca_id' => $marca->id, 'nombre' => 'iPhone 15']);

        $this->actingAs($this->admin)
            ->post(route('compras.store'), [
                'fecha' => '2026-04-16',
                'items' => [[
                    'categoria'       => 'funda',
                    'marca_id'        => $marca->id,
                    'modelo_id'       => $modelo->id,
                    'nombre_disenio'  => 'Degradé azul',
                    'cantidad'        => 4,
                    'precio_unitario' => 150,
                ]],
            ]);

        $compra = Compra::first();

        $this->actingAs($this->admin)
            ->delete(route('compras.destroy', ['compra' => $compra->id]))
            ->assertRedirect(route('compras.index'));

        $this->assertDatabaseHas('stocks', [
            'modelo_celular' => 'Apple iPhone 15',
            'nombre_disenio' => 'Degradé Azul',
            'cantidad'       => 0,
        ]);
    }

    public function test_pedido_decrementa_stock(): void
    {
        $stock = Stock::factory()->create(['cantidad' => 3]);

        $this->actingAs($this->admin)
            ->post(route('pedidos.store'), [
                'items' => [[
                    'stock_id'        => $stock->id,
                    'cantidad'        => 1,
                    'precio_unitario' => 2000,
                ]],
                'nombre'        => 'Juan',
                'apellido'      => 'Perez',
                'estado_pedido' => 'disponible',
                'estado_pago'   => 'no_pagado',
            ])
            ->assertRedirect(route('pedidos.index'));

        $this->assertDatabaseHas('stocks', [
            'id'       => $stock->id,
            'cantidad' => 2,
        ]);
    }

    public function test_eliminar_pedido_devuelve_stock(): void
    {
        $stock = Stock::factory()->create(['cantidad' => 2]);

        $this->actingAs($this->admin)
            ->post(route('pedidos.store'), [
                'items' => [[
                    'stock_id'        => $stock->id,
                    'cantidad'        => 1,
                    'precio_unitario' => 1500,
                ]],
                'nombre'        => 'Ana',
                'apellido'      => 'Garcia',
                'estado_pedido' => 'disponible',
                'estado_pago'   => 'no_pagado',
            ]);

        $pedido = Pedido::first();
        $this->assertDatabaseHas('stocks', ['id' => $stock->id, 'cantidad' => 1]);

        $this->actingAs($this->admin)
            ->delete(route('pedidos.destroy', $pedido))
            ->assertRedirect(route('pedidos.index'));

        $this->assertDatabaseHas('stocks', ['id' => $stock->id, 'cantidad' => 2]);
    }

    public function test_no_permite_pedido_sin_stock(): void
    {
        $stock = Stock::factory()->create(['cantidad' => 0]);

        $this->actingAs($this->admin)
            ->post(route('pedidos.store'), [
                'items' => [[
                    'stock_id'        => $stock->id,
                    'cantidad'        => 1,
                    'precio_unitario' => 1000,
                ]],
                'nombre'        => 'Carlos',
                'apellido'      => 'Lopez',
                'estado_pedido' => 'disponible',
                'estado_pago'   => 'no_pagado',
            ])
            ->assertSessionHasErrors('items');

        $this->assertDatabaseCount('pedidos', 0);
    }

    public function test_eliminar_compra_falla_si_stock_ya_vendido(): void
    {
        $marca  = Marca::factory()->create(['nombre' => 'Samsung']);
        $modelo = Modelo::factory()->create(['marca_id' => $marca->id, 'nombre' => 'Galaxy A54']);

        $this->actingAs($this->admin)
            ->post(route('compras.store'), [
                'fecha' => '2026-04-16',
                'items' => [[
                    'categoria'       => 'funda',
                    'marca_id'        => $marca->id,
                    'modelo_id'       => $modelo->id,
                    'nombre_disenio'  => 'Flores Rosas',
                    'cantidad'        => 5,
                    'precio_unitario' => 200,
                ]],
            ]);

        $compra = Compra::first();

        $stock = Stock::where('nombre_disenio', 'Flores Rosas')->first();

        $this->actingAs($this->admin)
            ->post(route('pedidos.store'), [
                'items' => [[
                    'stock_id'        => $stock->id,
                    'cantidad'        => 3,
                    'precio_unitario' => 2500,
                ]],
                'nombre'        => 'Juan',
                'apellido'      => 'Perez',
                'estado_pedido' => 'disponible',
                'estado_pago'   => 'pagado',
                'tipo_pago'     => 'efectivo',
            ]);

        $stock->refresh();
        $this->assertEquals(2, $stock->cantidad);

        $this->actingAs($this->admin)
            ->delete(route('compras.destroy', ['compra' => $compra->id]))
            ->assertSessionHasErrors('compra');
    }

    public function test_actualizar_compra_falla_si_stock_ya_vendido(): void
    {
        $marca  = Marca::factory()->create(['nombre' => 'Motorola']);
        $modelo = Modelo::factory()->create(['marca_id' => $marca->id, 'nombre' => 'Moto G84']);

        $this->actingAs($this->admin)
            ->post(route('compras.store'), [
                'fecha' => '2026-04-16',
                'items' => [[
                    'categoria'       => 'funda',
                    'marca_id'        => $marca->id,
                    'modelo_id'       => $modelo->id,
                    'nombre_disenio'  => 'Carbono Negro',
                    'cantidad'        => 5,
                    'precio_unitario' => 150,
                ]],
            ]);

        $compra = Compra::first();
        $stock = Stock::where('nombre_disenio', 'Carbono Negro')->first();

        $this->actingAs($this->admin)
            ->post(route('pedidos.store'), [
                'items' => [[
                    'stock_id'        => $stock->id,
                    'cantidad'        => 3,
                    'precio_unitario' => 1800,
                ]],
                'nombre'        => 'Ana',
                'apellido'      => 'Lopez',
                'estado_pedido' => 'disponible',
                'estado_pago'   => 'pagado',
                'tipo_pago'     => 'efectivo',
            ]);

        $stock->refresh();
        $this->assertEquals(2, $stock->cantidad);

        $marca2 = Marca::factory()->create(['nombre' => 'Nokia']);
        $modelo2 = Modelo::factory()->create(['marca_id' => $marca2->id, 'nombre' => 'G22']);

        $this->actingAs($this->admin)
            ->put(route('compras.update', $compra), [
                'fecha' => '2026-04-17',
                'items' => [[
                    'categoria'       => 'funda',
                    'marca_id'        => $marca2->id,
                    'modelo_id'       => $modelo2->id,
                    'nombre_disenio'  => 'Nuevo diseño',
                    'cantidad'        => 2,
                    'precio_unitario' => 100,
                ]],
            ])
            ->assertSessionHasErrors('compra');
    }

    public function test_stock_no_queda_negativo_al_eliminar_compra(): void
    {
        $marca  = Marca::factory()->create(['nombre' => 'Xiaomi']);
        $modelo = Modelo::factory()->create(['marca_id' => $marca->id, 'nombre' => 'Redmi 13C']);

        $this->actingAs($this->admin)
            ->post(route('compras.store'), [
                'fecha' => '2026-04-16',
                'items' => [[
                    'categoria'       => 'funda',
                    'marca_id'        => $marca->id,
                    'modelo_id'       => $modelo->id,
                    'nombre_disenio'  => 'Floral',
                    'cantidad'        => 3,
                    'precio_unitario' => 100,
                ]],
            ]);

        $compra = Compra::first();
        $stock = Stock::where('nombre_disenio', 'Floral')->first();

        $this->actingAs($this->admin)
            ->post(route('pedidos.store'), [
                'items' => [[
                    'stock_id'        => $stock->id,
                    'cantidad'        => 5,
                    'precio_unitario' => 1500,
                ]],
                'nombre'        => 'Pedro',
                'apellido'      => 'Sanchez',
                'estado_pedido' => 'disponible',
                'estado_pago'   => 'no_pagado',
            ])
            ->assertSessionHasErrors('items');

        $stock->refresh();
        $this->assertEquals(3, $stock->cantidad);

        $this->actingAs($this->admin)
            ->delete(route('compras.destroy', ['compra' => $compra->id]));

        $stock->refresh();
        $this->assertGreaterThanOrEqual(0, $stock->cantidad);
    }
}
