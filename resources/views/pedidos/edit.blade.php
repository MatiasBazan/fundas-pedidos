@extends('layouts.app')

@section('content')

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pedidos.index') }}"
           class="text-gray-400 hover:text-orange-500 transition">← Volver</a>
        <h1 class="text-2xl font-semibold text-gray-800">Editar pedido #{{ $pedido->id }}</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl mx-auto">
        <form method="POST" action="{{ route('pedidos.update', $pedido) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del diseño</label>
                    <input type="text" name="nombre_disenio" value="{{ old('nombre_disenio', $pedido->nombre_disenio) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('nombre_disenio') border-red-400 @enderror">
                    @error('nombre_disenio')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Modelo de celular</label>
                    <input type="text" name="modelo_celular" value="{{ old('modelo_celular', $pedido->modelo_celular) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('modelo_celular') border-red-400 @enderror">
                    @error('modelo_celular')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $pedido->nombre) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('nombre') border-red-400 @enderror">
                    @error('nombre')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                    <input type="text" name="apellido" value="{{ old('apellido', $pedido->apellido) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('apellido') border-red-400 @enderror">
                    @error('apellido')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Precio</label>
                    <input type="number" name="precio" value="{{ old('precio', $pedido->precio) }}" step="0.01" min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('precio') border-red-400 @enderror">
                    @error('precio')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado del pedido</label>
                    <select name="estado_pedido"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                        <option value="disponible" {{ old('estado_pedido', $pedido->estado_pedido) == 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="entregado"  {{ old('estado_pedido', $pedido->estado_pedido) == 'entregado'  ? 'selected' : '' }}>Entregado</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado de pago</label>
                    <select name="estado_pago" id="estado_pago"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                        <option value="no_pagado" {{ old('estado_pago', $pedido->estado_pago) == 'no_pagado' ? 'selected' : '' }}>No pagado</option>
                        <option value="pagado"    {{ old('estado_pago', $pedido->estado_pago) == 'pagado'    ? 'selected' : '' }}>Pagado</option>
                    </select>
                </div>

                <div id="tipo-pago-field" class="sm:col-span-2" style="display:none">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de pago</label>
                    <select name="tipo_pago"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                        <option value="efectivo"      {{ old('tipo_pago', $pedido->tipo_pago) == 'efectivo'      ? 'selected' : '' }}>Efectivo</option>
                        <option value="transferencia" {{ old('tipo_pago', $pedido->tipo_pago) == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                    </select>
                </div>

            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit"
                        class="flex-1 sm:flex-none bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                    Actualizar pedido
                </button>
                <a href="{{ route('pedidos.index') }}"
                   class="flex-1 sm:flex-none text-center border border-gray-300 text-gray-600 hover:text-orange-500 px-6 py-2 rounded-lg text-sm font-medium transition">
                    Cancelar
                </a>
            </div>

        </form>
    </div>

    <script>
        const estadoPago = document.getElementById('estado_pago');
        const tipoPagoField = document.getElementById('tipo-pago-field');

        function toggleTipoPago() {
            tipoPagoField.style.display = estadoPago.value === 'pagado' ? 'block' : 'none';
        }

        estadoPago.addEventListener('change', toggleTipoPago);
        toggleTipoPago();
    </script>

@endsection
