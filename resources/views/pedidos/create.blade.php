@extends('layouts.app')

@section('content')

<div class="mb-6">
    <a href="{{ route('pedidos.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-[#FF2D6B] transition-colors mb-3">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver a Ventas
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Nueva venta</h1>
    <p class="text-sm text-gray-500 mt-0.5">Completá los datos de la venta</p>
</div>

<div x-data="pedidoForm">
<form method="POST" action="{{ route('pedidos.store') }}" class="space-y-5">
    @csrf

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
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1.5">Fecha <span class="text-red-400">*</span></label>
                <input type="date" name="fecha" value="{{ old('fecha', now()->toDateString()) }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all @error('fecha') border-red-300 bg-red-50 @enderror">
                @error('fecha') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Productos --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
        <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
            <span class="w-1 h-4 bg-[#FF2D6B] rounded-full"></span>
            Productos vendidos
        </h2>

        @error('items') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror

        @if($fondas->isEmpty() && $accesorios->isEmpty())
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

        <template x-for="(item, index) in items" :key="index">
            <div class="border border-gray-100 rounded-xl p-4 space-y-3 bg-gray-50/40">

                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wide" x-text="'Producto ' + (index + 1)"></span>
                    <button type="button" @click="removeItem(index)" x-show="items.length > 1"
                            class="text-xs text-red-400 hover:text-red-600 hover:bg-red-50 px-2 py-1 rounded-lg transition-colors flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Quitar
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    {{-- Producto --}}
                    <div class="md:col-span-1">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Producto <span class="text-red-400">*</span></label>
                        <select :name="'items[' + index + '][stock_id]'" x-model="item.stock_id"
                                x-init="new TomSelect($el, { create: false, allowEmptyOption: true, sortField: false, placeholder: 'Seleccioná un producto' })">
                            <option value="">Seleccioná un producto</option>
                            @if($fondas->isNotEmpty())
                            <optgroup label="📱 Fundas">
                                @foreach($fondas as $stock)
                                    <option value="{{ $stock->id }}">{{ $stock->modelo_celular }} — {{ $stock->nombre_disenio }} ({{ $stock->cantidad }} uds. disponibles)</option>
                                @endforeach
                            </optgroup>
                            @endif
                            @if($accesorios->isNotEmpty())
                            <optgroup label="🛍 Accesorios">
                                @foreach($accesorios as $stock)
                                    <option value="{{ $stock->id }}">{{ $stock->nombre_disenio }} ({{ $stock->cantidad }} uds. disponibles)</option>
                                @endforeach
                            </optgroup>
                            @endif
                        </select>
                    </div>

                    {{-- Cantidad --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Cantidad <span class="text-red-400">*</span></label>
                        <input type="number" :name="'items[' + index + '][cantidad]'" x-model="item.cantidad"
                               min="1" placeholder="1"
                               class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all">
                    </div>

                    {{-- Precio de venta --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Precio de venta <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">$</span>
                            <input type="number" :name="'items[' + index + '][precio_unitario]'" x-model="item.precio_unitario"
                                   min="0" step="0.01" placeholder="0.00"
                                   class="w-full pl-6 pr-3 border border-gray-200 rounded-xl py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all">
                        </div>
                    </div>
                </div>

                {{-- Subtotal --}}
                <div class="flex justify-end">
                    <span class="text-xs text-gray-400 mr-2 self-center">Subtotal:</span>
                    <span class="text-sm font-bold text-[#FF2D6B]" x-text="'$' + fmt(itemTotal(item))">$0,00</span>
                </div>

            </div>
        </template>

        <button type="button" @click="addItem()"
                class="w-full py-2.5 border-2 border-dashed border-gray-200 hover:border-[#FF2D6B] text-gray-400 hover:text-[#FF2D6B] rounded-xl text-sm font-medium transition-all flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Agregar producto
        </button>

        <div class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-xl px-6 py-4">
            <span class="text-sm font-medium text-gray-500">Total general</span>
            <span class="text-xl font-bold text-[#FF2D6B]" x-text="'$' + fmt(totalGeneral)">$0,00</span>
        </div>

        @endif
    </div>

    {{-- Estados --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 flex items-center gap-2">
            <span class="w-1 h-4 bg-[#FF2D6B] rounded-full"></span>
            Estado y pago
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1.5">Estado del pedido</label>
                <select name="estado_pedido" data-ts>
                    <option value="disponible" {{ old('estado_pedido') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="entregado"  {{ old('estado_pedido') == 'entregado'  ? 'selected' : '' }}>Entregado</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1.5">Estado de pago</label>
                <select name="estado_pago" id="estado_pago" data-ts>
                    <option value="no_pagado" {{ old('estado_pago') == 'no_pagado' ? 'selected' : '' }}>No pagado</option>
                    <option value="pagado"    {{ old('estado_pago') == 'pagado'    ? 'selected' : '' }}>Pagado</option>
                </select>
            </div>
        </div>
        <div id="tipo-pago-field" class="mt-4 hidden">
            <label class="block text-sm font-medium text-gray-600 mb-1.5">Tipo de pago</label>
            <div class="w-full md:w-48">
                <select name="tipo_pago" data-ts>
                    <option value="efectivo"      {{ old('tipo_pago') == 'efectivo'      ? 'selected' : '' }}>Efectivo</option>
                    <option value="transferencia" {{ old('tipo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex items-center gap-3">
        <button type="submit" {{ ($fondas->isEmpty() && $accesorios->isEmpty()) ? 'disabled' : '' }}
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
    document.addEventListener('alpine:init', () => {
        Alpine.data('pedidoForm', () => ({
            items: [{ stock_id: '', cantidad: 1, precio_unitario: '' }],

            addItem() {
                this.items.push({ stock_id: '', cantidad: 1, precio_unitario: '' });
            },
            removeItem(i) {
                if (this.items.length > 1) this.items.splice(i, 1);
            },
            itemTotal(item) {
                return (parseFloat(item.cantidad) || 0) * (parseFloat(item.precio_unitario) || 0);
            },
            get totalGeneral() {
                return this.items.reduce((sum, item) => sum + this.itemTotal(item), 0);
            },
            fmt(n) {
                return n.toLocaleString('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }
        }));
    });

    const estadoPago = document.getElementById('estado_pago');
    const tipoPagoField = document.getElementById('tipo-pago-field');
    function toggleTipoPago() {
        tipoPagoField.classList.toggle('hidden', estadoPago.value !== 'pagado');
    }
    estadoPago.addEventListener('change', toggleTipoPago);
    toggleTipoPago();
</script>

@endsection
