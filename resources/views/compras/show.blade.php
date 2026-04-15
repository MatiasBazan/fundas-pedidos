@extends('layouts.app')

@section('content')

    <div class="mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('compras.index') }}" class="text-gray-400 hover:text-orange-500 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Compra #{{ $compra->id }}</h1>
                <p class="text-gray-600 mt-1">{{ $compra->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="max-w-2xl space-y-6">

        {{-- Datos principales --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                <h2 class="text-white font-bold text-lg">Detalle de la compra</h2>
            </div>
            <div class="divide-y divide-gray-100">
                <div class="px-6 py-4 flex justify-between items-center">
                    <span class="text-sm font-semibold text-gray-500">Modelo de celular</span>
                    <span class="text-sm font-bold text-gray-800">{{ $compra->modelo_celular }}</span>
                </div>
                <div class="px-6 py-4 flex justify-between items-center">
                    <span class="text-sm font-semibold text-gray-500">Nombre de diseño</span>
                    <span class="text-sm font-bold text-gray-800">{{ $compra->nombre_disenio }}</span>
                </div>
                <div class="px-6 py-4 flex justify-between items-center">
                    <span class="text-sm font-semibold text-gray-500">Cantidad</span>
                    <span class="text-sm font-bold text-gray-800">{{ number_format($compra->cantidad) }} unidades</span>
                </div>
                <div class="px-6 py-4 flex justify-between items-center">
                    <span class="text-sm font-semibold text-gray-500">Precio unitario</span>
                    <span class="text-sm font-bold text-gray-800">${{ number_format($compra->precio_unitario, 2, ',', '.') }}</span>
                </div>
                <div class="px-6 py-4 flex justify-between items-center bg-orange-50">
                    <span class="text-sm font-bold text-orange-700">Precio total</span>
                    <span class="text-2xl font-bold text-orange-700">${{ number_format($compra->precio_total, 2, ',', '.') }}</span>
                </div>
                @if($compra->observaciones)
                <div class="px-6 py-4">
                    <span class="text-sm font-semibold text-gray-500 block mb-1">Observaciones</span>
                    <p class="text-sm text-gray-700">{{ $compra->observaciones }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Acciones --}}
        <div class="flex gap-3">
            <a href="{{ route('compras.edit', $compra) }}"
               class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Editar
            </a>
            <form method="POST" action="{{ route('compras.destroy', $compra) }}"
                  onsubmit="return confirm('¿Eliminar esta compra?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-100 hover:bg-red-200 text-red-700 px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Eliminar
                </button>
            </form>
            <a href="{{ route('compras.index') }}"
               class="border-2 border-gray-300 hover:border-orange-500 hover:text-orange-600 text-gray-600 px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-200">
                Volver
            </a>
        </div>

    </div>

@endsection
