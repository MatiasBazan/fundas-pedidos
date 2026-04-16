@extends('layouts.app')

@section('content')

<div class="mb-6">
    <a href="{{ route('pedidos.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-[#FF2D6B] transition-colors mb-3">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver a Pedidos
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Nuevo pedido</h1>
    <p class="text-sm text-gray-500 mt-0.5">Completá los datos del pedido</p>
</div>

<div class="max-w-3xl">
    <form method="POST" action="{{ route('pedidos.store') }}" class="space-y-5">
        @csrf

        {{-- Producto --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                <span class="w-1 h-4 bg-[#FF2D6B] rounded-full"></span>
                Producto
            </h2>

            @if($stockDisponible->isEmpty())
                <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-xl p-4">
                    <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-amber-800">No hay productos en stock</p>
                        <p class="text-xs text-amber-700 mt-0.5">Primero registrá una <a href="{{ route('compras.create') }}" class="underline hover:text-amber-900">compra al mayorista</a>.</p>
                    </div>
                </div>
            @else
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Producto <span class="text-red-400">*</span></label>
                    <select name="stock_id"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all bg-white @error('stock_id') border-red-300 bg-red-50 @enderror">
                        <option value="">Seleccioná un producto</option>
                        @foreach($stockDisponible as $stock)
                            <option value="{{ $stock->id }}" {{ old('stock_id') == $stock->id ? 'selected' : '' }}>
                                {{ $stock->modelo_celular }} — {{ $stock->nombre_disenio }} ({{ $stock->cantidad }} disponibles)
                            </option>
                        @endforeach
                    </select>
                    @error('stock_id')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            @endif
        </div>

        {{-- Cliente --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                <span class="w-1 h-4 bg-[#FF2D6B] rounded-full"></span>
                Cliente
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Nombre <span class="text-red-400">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Nombre del cliente"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all @error('nombre') border-red-300 bg-red-50 @enderror">
                    @error('nombre') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Apellido <span class="text-red-400">*</span></label>
                    <input type="text" name="apellido" value="{{ old('apellido') }}" placeholder="Apellido del cliente"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all @error('apellido') border-red-300 bg-red-50 @enderror">
                    @error('apellido') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Precio y estados --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                <span class="w-1 h-4 bg-[#FF2D6B] rounded-full"></span>
                Precio y estados
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Precio ($) <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">$</span>
                        <input type="number" name="precio" value="{{ old('precio') }}" step="0.01" min="0" placeholder="0.00"
                               class="w-full pl-7 pr-4 border border-gray-200 rounded-xl py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all @error('precio') border-red-300 bg-red-50 @enderror">
                    </div>
                    @error('precio') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Estado del pedido</label>
                    <select name="estado_pedido" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all bg-white">
                        <option value="disponible" {{ old('estado_pedido') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="entregado"  {{ old('estado_pedido') == 'entregado'  ? 'selected' : '' }}>Entregado</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Estado de pago</label>
                    <select name="estado_pago" id="estado_pago" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all bg-white">
                        <option value="no_pagado" {{ old('estado_pago') == 'no_pagado' ? 'selected' : '' }}>No pagado</option>
                        <option value="pagado"    {{ old('estado_pago') == 'pagado'    ? 'selected' : '' }}>Pagado</option>
                    </select>
                </div>
            </div>
            <div id="tipo-pago-field" class="mt-4 hidden">
                <label class="block text-sm font-medium text-gray-600 mb-1.5">Tipo de pago</label>
                <select name="tipo_pago" class="w-full md:w-48 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all bg-white">
                    <option value="efectivo"      {{ old('tipo_pago') == 'efectivo'      ? 'selected' : '' }}>Efectivo</option>
                    <option value="transferencia" {{ old('tipo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                </select>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3">
            <button type="submit" {{ $stockDisponible->isEmpty() ? 'disabled' : '' }}
                    class="px-6 py-2.5 bg-[#FF2D6B] hover:bg-[#E0245E] text-white rounded-xl text-sm font-semibold transition-all shadow-sm shadow-[#FF2D6B]/30 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Guardar pedido
            </button>
            <a href="{{ route('pedidos.index') }}" class="px-6 py-2.5 bg-white hover:bg-gray-50 text-gray-600 hover:text-gray-800 font-medium rounded-xl border border-gray-200 shadow-sm transition">
                Cancelar
            </a>
        </div>

    </form>
</div>

<script>
    const estadoPago = document.getElementById('estado_pago');
    const tipoPagoField = document.getElementById('tipo-pago-field');
    function toggleTipoPago() {
        tipoPagoField.classList.toggle('hidden', estadoPago.value !== 'pagado');
    }
    estadoPago.addEventListener('change', toggleTipoPago);
    toggleTipoPago();
</script>

@endsection
