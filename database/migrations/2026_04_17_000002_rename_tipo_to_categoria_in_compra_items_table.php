<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('compra_items', function (Blueprint $table) {
            $table->renameColumn('tipo', 'categoria');
        });
    }

    public function down(): void
    {
        Schema::table('compra_items', function (Blueprint $table) {
            $table->renameColumn('categoria', 'tipo');
        });
    }
};
