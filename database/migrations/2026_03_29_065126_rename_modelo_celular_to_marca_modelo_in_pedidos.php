<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Eliminar columna vieja
            $table->dropColumn('modelo_celular');

            // Agregar nuevas columnas
            $table->string('marca')->nullable()->after('nombre_disenio');
            $table->string('modelo')->nullable()->after('marca');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Revertir los cambios
            $table->dropColumn(['marca', 'modelo']);
            $table->string('modelo_celular')->nullable()->after('nombre_disenio');
        });
    }
};
