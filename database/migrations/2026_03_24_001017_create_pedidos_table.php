<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_disenio');
            $table->string('modelo_celular');
            $table->string('nombre');
            $table->string('apellido');
            $table->decimal('precio', 8, 2);
            $table->enum('estado_pedido', ['disponible', 'entregado'])->default('disponible');
            $table->enum('estado_pago', ['pagado', 'no_pagado'])->default('no_pagado');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
