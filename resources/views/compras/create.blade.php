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
                <h1 class="text-3xl font-bold text-gray-800">Nueva compra</h1>
                <p class="text-gray-600 mt-1">Registrá una compra al mayorista</p>
            </div>
        </div>
    </div>

    <div class="max-w-2xl">
        <form method="POST" action="{{ route('compras.store') }}" class="bg-white rounded-xl shadow-md p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Modelo de celular <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="modelo_celular" value="{{ old('modelo_celular') }}"
                           placeholder="Ej: iPhone 14 Pro"
                           class="w-full border @error('modelo_celular') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                    @error('modelo_celular')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nombre de diseño <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nombre_disenio" value="{{ old('nombre_disenio') }}"
                           placeholder="Ej: Flores rosas"
                           class="w-full border @error('nombre_disenio') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                    @error('nombre_disenio')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Cantidad <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="cantidad" value="{{ old('cantidad') }}"
                           min="1" placeholder="0"
                           class="w-full border @error('cantidad') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                           x-model="cantidad" @input="calcTotal()">
                    @error('cantidad')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Precio unitario <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-medium text-sm">$</span>
                        <input type="number" name="precio_unitario" value="{{ old('precio_unitario') }}"
                               min="0" step="0.01" placeholder="0.00"
                               class="w-full border @error('precio_unitario') border-red-400 @else border-gray-300 @enderror rounded-lg pl-7 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                               x-model="precioUnitario" @input="calcTotal()">
                    </div>
                    @error('precio_unitario')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Precio total calculado --}}
            <div x-data="{ cantidad: '{{ old('cantidad', '') }}', precioUnitario: '{{ old('precio_unitario', '') }}', get total() { return (parseFloat(this.cantidad) || 0) * (parseFloat(this.precioUnitario) || 0); } }">
                <div class="bg-orange-50 border-2 border-orange-200 rounded-xl px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-semibold text-orange-800">Precio total (calculado automáticamente)</span>
                    </div>
                    <span class="text-2xl font-bold text-orange-700" x-text="'$' + total.toLocaleString('es-AR', {minimumFractionDigits: 2, maximumFractionDigits: 2})">$0,00</span>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Observaciones</label>
                <textarea name="observaciones" rows="3" placeholder="Notas adicionales..."
                          class="w-full border @error('observaciones') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition resize-none">{{ old('observaciones') }}</textarea>
                @error('observaciones')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-3 rounded-xl text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg">
                    Registrar compra
                </button>
                <a href="{{ route('compras.index') }}"
                   class="border-2 border-gray-300 hover:border-orange-500 hover:text-orange-600 text-gray-600 px-8 py-3 rounded-xl text-sm font-semibold transition-all duration-200">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

@endsection
