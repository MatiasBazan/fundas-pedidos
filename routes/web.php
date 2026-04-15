<?php

use App\Http\Controllers\CompraController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
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

    Route::resource('compras', CompraController::class);

    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');

    Route::get('/estadisticas', [StatsController::class, 'index'])->name('stats.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::post('/users/{user}/impersonate', [ImpersonateController::class, 'start'])->name('impersonate.start');
    });

    Route::post('/impersonate/stop', [ImpersonateController::class, 'stop'])->name('impersonate.stop');
});

require __DIR__.'/auth.php';
