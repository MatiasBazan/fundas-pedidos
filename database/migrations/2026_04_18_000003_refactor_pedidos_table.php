<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Paso 1: soltar FK y el índice regular de stock_id, y FKs de marca/modelo
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropForeign(['stock_id']);
            $table->dropIndex(['stock_id']);
            $table->dropForeign(['marca_id']);
            $table->dropForeign(['modelo_id']);
        });

        // Paso 2: quitar columnas y agregar precio_total
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn(['stock_id', 'nombre_disenio', 'marca', 'modelo', 'marca_id', 'modelo_id', 'precio']);
            $table->decimal('precio_total', 8, 2)->default(0)->after('apellido');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn('precio_total');
            $table->decimal('precio', 12, 2)->default(0)->after('apellido');
            $table->string('nombre_disenio')->nullable()->after('id');
            $table->string('marca')->nullable()->after('nombre_disenio');
            $table->string('modelo')->nullable()->after('marca');
            $table->foreignId('stock_id')->nullable()->after('id');
            $table->unsignedBigInteger('marca_id')->nullable();
            $table->unsignedBigInteger('modelo_id')->nullable();
        });
    }
};
