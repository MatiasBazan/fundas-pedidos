<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->date('fecha')->after('id')->default(now()->toDateString());
            $table->dropColumn(['modelo_celular', 'nombre_disenio', 'cantidad', 'precio_unitario', 'precio_total']);
        });
    }

    public function down(): void
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->dropColumn('fecha');
            $table->string('modelo_celular')->after('id');
            $table->string('nombre_disenio')->after('modelo_celular');
            $table->integer('cantidad')->after('nombre_disenio');
            $table->decimal('precio_unitario', 8, 2)->after('cantidad');
            $table->decimal('precio_total', 8, 2)->after('precio_unitario');
        });
    }
};
