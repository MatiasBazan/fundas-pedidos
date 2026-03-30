<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->foreignId('marca_id')->nullable()->constrained('marcas')->nullOnDelete()->after('nombre_disenio');
            $table->foreignId('modelo_id')->nullable()->constrained('modelos')->nullOnDelete()->after('marca_id');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('marca_id');
            $table->dropConstrainedForeignId('modelo_id');
        });
    }
};
