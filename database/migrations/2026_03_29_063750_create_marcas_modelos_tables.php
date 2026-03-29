<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marcas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->boolean('es_personalizada')->default(false);
            $table->timestamps();
        });

        Schema::create('modelos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marca_id')->constrained('marcas')->onDelete('cascade');
            $table->string('nombre');
            $table->boolean('es_personalizado')->default(false);
            $table->timestamps();

            $table->unique(['marca_id', 'nombre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modelos');
        Schema::dropIfExists('marcas');
    }
};
