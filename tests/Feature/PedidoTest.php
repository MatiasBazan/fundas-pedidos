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
                'items' => [[
                    'stock_id'        => $stock->id,
                    'cantidad'        => 1,
                    'precio_unitario' => 3500,
                ]],
                'nombre'        => 'Maria',
                'apellido'      => 'Gonzalez',
                'estado_pedido' => 'disponible',
                'estado_pago'   => 'pagado',
                'tipo_pago'     => 'efectivo',
            ])
            ->assertRedirect(route('pedidos.index'));

        $this->assertDatabaseHas('pedidos', [
            'nombre'   => 'Maria',
            'apellido' => 'Gonzalez',
            'user_id'  => $this->admin->id,
        ]);

        $pedido = Pedido::first();
        $this->assertDatabaseHas('pedido_items', [
            'pedido_id'      => $pedido->id,
            'stock_id'      => $stock->id,
            'cantidad'      => 1,
            'precio_unitario' => 3500,
        ]);
    }

    public function test_pedido_requiere_campos_obligatorios(): void
    {
        $this->actingAs($this->admin)
            ->post(route('pedidos.store'), [])
            ->assertSessionHasErrors(['items', 'nombre', 'apellido', 'estado_pedido', 'estado_pago']);
    }

    public function test_actualizar_pedido(): void
    {
        $stock1 = Stock::factory()->create(['cantidad' => 2]);
        $stock2 = Stock::factory()->create(['cantidad' => 2]);

        $this->actingAs($this->admin)
            ->post(route('pedidos.store'), [
                'items' => [[
                    'stock_id'        => $stock1->id,
                    'cantidad'        => 1,
                    'precio_unitario' => 2000,
                ]],
                'nombre'        => 'Luis',
                'apellido'      => 'Martinez',
                'estado_pedido' => 'disponible',
                'estado_pago'   => 'no_pagado',
            ]);

        $pedido = Pedido::first();

        $this->actingAs($this->admin)
            ->put(route('pedidos.update', $pedido), [
                'items' => [[
                    'stock_id'        => $stock2->id,
                    'cantidad'        => 1,
                    'precio_unitario' => 2500,
                ]],
                'nombre'        => 'Luis',
                'apellido'      => 'Martinez',
                'estado_pedido' => 'entregado',
                'estado_pago'   => 'pagado',
                'tipo_pago'     => 'transferencia',
            ])
            ->assertRedirect(route('pedidos.index'));

        $this->assertDatabaseHas('pedidos', [
            'id'            => $pedido->id,
            'estado_pedido' => 'entregado',
        ]);

        $stock1->refresh();
        $stock2->refresh();
        $this->assertEquals(2, $stock1->cantidad);
        $this->assertEquals(1, $stock2->cantidad);
    }

    public function test_eliminar_pedido(): void
    {
        $stock = Stock::factory()->create(['cantidad' => 3]);

        $this->actingAs($this->admin)
            ->post(route('pedidos.store'), [
                'items' => [[
                    'stock_id'        => $stock->id,
                    'cantidad'        => 1,
                    'precio_unitario' => 1800,
                ]],
                'nombre'        => 'Pedro',
                'apellido'      => 'Ramirez',
                'estado_pedido' => 'disponible',
                'estado_pago'   => 'no_pagado',
            ]);

        $pedido = Pedido::first();

        $this->actingAs($this->admin)
            ->delete(route('pedidos.destroy', $pedido))
            ->assertRedirect(route('pedidos.index'));

        $this->assertSoftDeleted('pedidos', ['id' => $pedido->id]);
    }

    public function test_admin_puede_ver_pedido_de_otro_usuario(): void
    {
        $user = User::factory()->create();
        $stock = Stock::factory()->create(['cantidad' => 5]);

        $this->actingAs($user)
            ->post(route('pedidos.store'), [
                'items' => [[
                    'stock_id'        => $stock->id,
                    'cantidad'        => 1,
                    'precio_unitario' => 2000,
                ]],
                'nombre'        => 'Usuario',
                'apellido'      => 'Normal',
                'estado_pedido' => 'disponible',
                'estado_pago'   => 'no_pagado',
            ]);

        $pedido = Pedido::first();

        $this->actingAs($this->admin)
            ->get(route('pedidos.show', $pedido))
            ->assertStatus(200);
    }

    public function test_usuario_no_puede_ver_pedido_de_otro(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $stock = Stock::factory()->create(['cantidad' => 5]);

        $this->actingAs($user1)
            ->post(route('pedidos.store'), [
                'items' => [[
                    'stock_id'        => $stock->id,
                    'cantidad'        => 1,
                    'precio_unitario' => 2000,
                ]],
                'nombre'        => 'Usuario1',
                'apellido'      => 'Test',
                'estado_pedido' => 'disponible',
                'estado_pago'   => 'no_pagado',
            ]);

        $pedido = Pedido::first();

        $this->actingAs($user2)
            ->get(route('pedidos.show', $pedido))
            ->assertStatus(403);
    }

    public function test_pedido_con_multiples_items(): void
    {
        $stock1 = Stock::factory()->create(['cantidad' => 5, 'nombre_disenio' => 'Diseño 1', 'modelo_celular' => 'Samsung A54']);
        $stock2 = Stock::factory()->create(['cantidad' => 3, 'nombre_disenio' => 'Diseño 2', 'modelo_celular' => 'iPhone 15']);

        $this->actingAs($this->admin)
            ->post(route('pedidos.store'), [
                'items' => [
                    [
                        'stock_id'        => $stock1->id,
                        'cantidad'        => 2,
                        'precio_unitario' => 2000,
                    ],
                    [
                        'stock_id'        => $stock2->id,
                        'cantidad'        => 1,
                        'precio_unitario' => 3500,
                    ],
                ],
                'nombre'        => 'Multi',
                'apellido'      => 'Items',
                'estado_pedido' => 'disponible',
                'estado_pago'   => 'pagado',
                'tipo_pago'     => 'efectivo',
            ])
            ->assertRedirect(route('pedidos.index'));

        $stock1->refresh();
        $stock2->refresh();

        $this->assertEquals(3, $stock1->cantidad);
        $this->assertEquals(2, $stock2->cantidad);

        $pedido = Pedido::first();
        $this->assertEquals(7500, $pedido->precio_total);
    }
}