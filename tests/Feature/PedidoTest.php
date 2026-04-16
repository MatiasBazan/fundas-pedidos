<?php

namespace Tests\Feature;

use App\Models\Pedido;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PedidoTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_crear_pedido_exitoso(): void
    {
        $stock = Stock::factory()->create(['cantidad' => 5]);

        $this->actingAs($this->admin)
            ->post(route('pedidos.store'), [
                'stock_id'      => $stock->id,
                'nombre'        => 'Maria',
                'apellido'      => 'Gonzalez',
                'precio'        => 3500,
                'estado_pedido' => 'disponible',
                'estado_pago'   => 'pagado',
                'tipo_pago'     => 'efectivo',
            ])
            ->assertRedirect(route('pedidos.index'));

        $this->assertDatabaseHas('pedidos', [
            'stock_id' => $stock->id,
            'nombre'   => 'Maria',
            'apellido' => 'Gonzalez',
            'precio'   => 3500,
            'user_id'  => $this->admin->id,
        ]);
    }

    public function test_pedido_requiere_campos_obligatorios(): void
    {
        $this->actingAs($this->admin)
            ->post(route('pedidos.store'), [])
            ->assertSessionHasErrors(['stock_id', 'nombre', 'apellido', 'precio']);
    }

    public function test_actualizar_pedido(): void
    {
        $stock1 = Stock::factory()->create(['cantidad' => 2]);
        $stock2 = Stock::factory()->create(['cantidad' => 2]);

        // Crear pedido → stock1.cantidad baja a 1
        $this->actingAs($this->admin)
            ->post(route('pedidos.store'), [
                'stock_id'      => $stock1->id,
                'nombre'        => 'Luis',
                'apellido'      => 'Martinez',
                'precio'        => 2000,
                'estado_pedido' => 'disponible',
                'estado_pago'   => 'no_pagado',
            ]);

        $pedido = Pedido::first();

        // Actualizar cambiando a stock2
        $this->actingAs($this->admin)
            ->put(route('pedidos.update', $pedido), [
                'stock_id'      => $stock2->id,
                'nombre'        => 'Luis',
                'apellido'      => 'Martinez',
                'precio'        => 2500,
                'estado_pedido' => 'entregado',
                'estado_pago'   => 'pagado',
                'tipo_pago'     => 'transferencia',
            ])
            ->assertRedirect(route('pedidos.index'));

        $this->assertDatabaseHas('pedidos', [
            'id'            => $pedido->id,
            'precio'        => 2500,
            'estado_pedido' => 'entregado',
            'stock_id'      => $stock2->id,
        ]);

        // stock1 restaurado, stock2 decrementado
        $this->assertDatabaseHas('stocks', ['id' => $stock1->id, 'cantidad' => 2]);
        $this->assertDatabaseHas('stocks', ['id' => $stock2->id, 'cantidad' => 1]);
    }

    public function test_eliminar_pedido(): void
    {
        $stock = Stock::factory()->create(['cantidad' => 3]);

        $this->actingAs($this->admin)
            ->post(route('pedidos.store'), [
                'stock_id'      => $stock->id,
                'nombre'        => 'Pedro',
                'apellido'      => 'Ramirez',
                'precio'        => 1800,
                'estado_pedido' => 'disponible',
                'estado_pago'   => 'no_pagado',
            ]);

        $pedido = Pedido::first();

        $this->actingAs($this->admin)
            ->delete(route('pedidos.destroy', $pedido))
            ->assertRedirect(route('pedidos.index'));

        $this->assertSoftDeleted('pedidos', ['id' => $pedido->id]);
    }
}
