<?php

use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('pedidos.index');
});

Route::middleware('auth')->group(function () {
    // IMPORTANTE: Rutas específicas ANTES de resource
    Route::get('/pedidos/dashboard', [PedidoController::class, 'dashboard'])->name('pedidos.dashboard');
    Route::get('/pedidos/export', [PedidoController::class, 'exportCsv'])->name('pedidos.export');
    Route::get('/api/modelos/{marca}', [PedidoController::class, 'getModelos']);

    // Ahora sí la ruta resource
    Route::resource('pedidos', PedidoController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
