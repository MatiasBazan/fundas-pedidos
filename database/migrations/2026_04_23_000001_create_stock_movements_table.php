<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained()->onDelete('cascade');
            $table->enum('tipo', ['compra_entrada', 'compra_eliminada', 'venta', 'venta_cancelada']);
            $table->integer('cantidad');
            $table->integer('cantidad_anterior');
            $table->integer('cantidad_nueva');
            $table->string('referencia_tipo')->nullable();
            $table->unsignedInteger('referencia_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};