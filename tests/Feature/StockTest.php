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
            'nombre_disenio' => 'Flores rosas',
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
                    'marca_id'        => $marca->id,
                    'modelo_id'       => $modelo->id,
                    'nombre_disenio'  => 'Degradé azul',
                    'cantidad'        => 4,
                    'precio_unitario' => 150,
                ]],
            ]);

        $compra = Compra::first();

        $this->actingAs($this->admin)
            ->delete(route('compras.destroy', $compra))
            ->assertRedirect(route('compras.index'));

        $this->assertDatabaseHas('stocks', [
            'modelo_celular' => 'Apple iPhone 15',
            'nombre_disenio' => 'Degradé azul',
            'cantidad'       => 0,
        ]);
    }

    public function test_pedido_decrementa_stock(): void
    {
        $stock = Stock::factory()->create(['cantidad' => 3]);

        $this->actingAs($this->admin)
            ->post(route('pedidos.store'), [
                'stock_id'      => $stock->id,
                'nombre'        => 'Juan',
                'apellido'      => 'Perez',
                'precio'        => 2000,
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
                'stock_id'      => $stock->id,
                'nombre'        => 'Ana',
                'apellido'      => 'Garcia',
                'precio'        => 1500,
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
                'stock_id'      => $stock->id,
                'nombre'        => 'Carlos',
                'apellido'      => 'Lopez',
                'precio'        => 1000,
                'estado_pedido' => 'disponible',
                'estado_pago'   => 'no_pagado',
            ])
            ->assertSessionHasErrors('stock_id');

        $this->assertDatabaseCount('pedidos', 0);
    }
}
