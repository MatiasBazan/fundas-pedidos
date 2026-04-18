<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->enum('categoria', ['funda', 'accesorio'])->default('funda')->after('id');
            $table->dropUnique(['modelo_celular', 'nombre_disenio']);
            $table->unique(['categoria', 'modelo_celular', 'nombre_disenio']);
        });
    }

    public function down(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropUnique(['categoria', 'modelo_celular', 'nombre_disenio']);
            $table->unique(['modelo_celular', 'nombre_disenio']);
            $table->dropColumn('categoria');
        });
    }
};
