<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('estado_pedido');
            $table->index('estado_pago');
            $table->index('stock_id');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['estado_pedido']);
            $table->dropIndex(['estado_pago']);
            $table->dropIndex(['stock_id']);
        });
    }
};
