<?php

namespace Tests\Feature;

use App\Models\Compra;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompraTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_crear_compra_con_multiples_items(): void
    {
        $marca   = Marca::factory()->create(['nombre' => 'Motorola']);
        $modelo1 = Modelo::factory()->create(['marca_id' => $marca->id, 'nombre' => 'Moto G84']);
        $modelo2 = Modelo::factory()->create(['marca_id' => $marca->id, 'nombre' => 'Moto G54']);

        $this->actingAs($this->admin)
            ->post(route('compras.store'), [
                'fecha' => '2026-04-16',
                'items' => [
                    [
                        'marca_id'        => $marca->id,
                        'modelo_id'       => $modelo1->id,
                        'nombre_disenio'  => 'Marmol blanco',
                        'cantidad'        => 3,
                        'precio_unitario' => 250,
                    ],
                    [
                        'marca_id'        => $marca->id,
                        'modelo_id'       => $modelo2->id,
                        'nombre_disenio'  => 'Carbono negro',
                        'cantidad'        => 2,
                        'precio_unitario' => 300,
                    ],
                ],
            ])
            ->assertRedirect(route('compras.index'));

        $this->assertDatabaseCount('compras', 1);
        $this->assertDatabaseCount('compra_items', 2);
        $this->assertDatabaseHas('compras', ['fecha' => '2026-04-16']);
    }

    public function test_compra_requiere_al_menos_un_item(): void
    {
        $this->actingAs($this->admin)
            ->post(route('compras.store'), [
                'fecha' => '2026-04-16',
                'items' => [],
            ])
            ->assertSessionHasErrors('items');

        $this->assertDatabaseCount('compras', 0);
    }

    public function test_precio_total_calculado_correctamente(): void
    {
        $marca  = Marca::factory()->create(['nombre' => 'Xiaomi']);
        $modelo = Modelo::factory()->create(['marca_id' => $marca->id, 'nombre' => 'Redmi 13C']);

        $this->actingAs($this->admin)
            ->post(route('compras.store'), [
                'fecha' => '2026-04-16',
                'items' => [[
                    'marca_id'        => $marca->id,
                    'modelo_id'       => $modelo->id,
                    'nombre_disenio'  => 'Floral',
                    'cantidad'        => 4,
                    'precio_unitario' => 175,
                ]],
            ]);

        $this->assertDatabaseHas('compra_items', [
            'cantidad'        => 4,
            'precio_unitario' => 175,
            'precio_total'    => 700,
        ]);
    }

    public function test_eliminar_compra_elimina_items(): void
    {
        $marca  = Marca::factory()->create(['nombre' => 'Nokia']);
        $modelo = Modelo::factory()->create(['marca_id' => $marca->id, 'nombre' => 'G22']);

        $this->actingAs($this->admin)
            ->post(route('compras.store'), [
                'fecha' => '2026-04-16',
                'items' => [
                    [
                        'marca_id'        => $marca->id,
                        'modelo_id'       => $modelo->id,
                        'nombre_disenio'  => 'Diseño A',
                        'cantidad'        => 5,
                        'precio_unitario' => 100,
                    ],
                    [
                        'marca_id'        => $marca->id,
                        'modelo_id'       => $modelo->id,
                        'nombre_disenio'  => 'Diseño B',
                        'cantidad'        => 3,
                        'precio_unitario' => 120,
                    ],
                ],
            ]);

        $compra = Compra::first();
        $this->assertDatabaseCount('compra_items', 2);

        $this->actingAs($this->admin)
            ->delete(route('compras.destroy', $compra))
            ->assertRedirect(route('compras.index'));

        $this->assertDatabaseCount('compra_items', 0);
        $this->assertDatabaseMissing('compras', ['id' => $compra->id]);
    }
}
