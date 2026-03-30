@extends('layouts.app')

@section('content')

    <div class="mb-8">
        <a href="{{ route('pedidos.index') }}"
           class="inline-flex items-center gap-2 text-gray-600 hover:text-orange-500 transition-colors font-medium mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Volver a Pedidos
        </a>
        <h1 class="text-3xl font-bold text-gray-800 mt-2">Nuevo Pedido</h1>
        <p class="text-gray-600 mt-1">Completa los datos para crear un nuevo pedido</p>
    </div>

    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow max-w-3xl mx-auto">
        <!-- Header del formulario -->
        <div class="bg-gradient-to-r from-orange-50 to-orange-100 border-b border-orange-200 px-8 py-6 rounded-t-xl">
            <div class="flex items-center gap-3">
                <div class="bg-orange-500 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Información del Pedido</h2>
                    <p class="text-sm text-gray-600">Todos los campos son obligatorios</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('pedidos.store') }}" class="p-8">
            @csrf

            <div class="space-y-6">

                <!-- Nombre del diseño -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                        </svg>
                        Nombre del diseño
                    </label>
                    <input type="text" name="nombre_disenio" value="{{ old('nombre_disenio') }}"
                           placeholder="Ej: Funda Flores"
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition-all @error('nombre_disenio') border-red-400 @enderror">
                    @error('nombre_disenio')
                    <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Marca y Modelo -->
                <div class="bg-gray-50 rounded-xl p-6 border-2 border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <rect x="7" y="2" width="10" height="20" rx="2"></rect>
                            <circle cx="12" cy="18" r="1"></circle>
                        </svg>
                        Dispositivo
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Marca -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Marca</label>
                            <select id="marca" name="marca_id"
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition-all">
                                <option value="">Seleccione una marca</option>
                                @foreach($marcas as $marca)
                                    <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                @endforeach
                                <option value="otra">➕ Otra marca (escribir)</option>
                            </select>

                            <input type="text"
                                   id="marca_otra"
                                   name="marca_otra"
                                   placeholder="Escriba la marca"
                                   value="{{ old('marca_otra') }}"
                                   class="mt-3 hidden w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition-all">
                            @error('marca_id')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                            @error('marca_otra')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Modelo -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Modelo</label>
                            <select id="modelo"
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition-all disabled:bg-gray-100 disabled:cursor-not-allowed"
                                    disabled>
                                <option value="">Primero seleccione una marca</option>
                            </select>

                            <input type="text"
                                   id="modelo_otro"
                                   placeholder="Escriba el modelo"
                                   value="{{ old('modelo_otro') }}"
                                   class="mt-3 hidden w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition-all">
                            @error('modelo_id')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                            @error('modelo_otro')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Datos del cliente -->
                <div class="bg-blue-50 rounded-xl p-6 border-2 border-blue-100">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                        Datos del Cliente
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}"
                                   placeholder="Nombre del cliente"
                                   class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition-all @error('nombre') border-red-400 @enderror">
                            @error('nombre')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Apellido</label>
                            <input type="text" name="apellido" value="{{ old('apellido') }}"
                                   placeholder="Apellido del cliente"
                                   class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition-all @error('apellido') border-red-400 @enderror">
                            @error('apellido')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Información del pedido -->
                <div class="bg-green-50 rounded-xl p-6 border-2 border-green-100">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                        </svg>
                        Precio y Estados
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Precio ($)</label>
                            <input type="number" name="precio" value="{{ old('precio') }}" step="0.01" min="0"
                                   placeholder="0.00"
                                   class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition-all @error('precio') border-red-400 @enderror">
                            @error('precio')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Estado del pedido</label>
                            <select name="estado_pedido"
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition-all">
                                <option value="disponible" {{ old('estado_pedido') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                <option value="entregado"  {{ old('estado_pedido') == 'entregado'  ? 'selected' : '' }}>Entregado</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Estado de pago</label>
                            <select name="estado_pago" id="estado_pago"
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition-all">
                                <option value="no_pagado" {{ old('estado_pago') == 'no_pagado' ? 'selected' : '' }}>No pagado</option>
                                <option value="pagado"    {{ old('estado_pago') == 'pagado'    ? 'selected' : '' }}>Pagado</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tipo de pago (condicional) -->
                    <div id="tipo-pago-field" class="mt-4 hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tipo de pago</label>
                        <select name="tipo_pago"
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition-all">
                            <option value="efectivo"      {{ old('tipo_pago') == 'efectivo'      ? 'selected' : '' }}>Efectivo</option>
                            <option value="transferencia" {{ old('tipo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                        </select>
                    </div>
                </div>

            </div>

            <!-- Botones de acción -->
            <div class="mt-8 flex gap-3 pt-6 border-t-2 border-gray-100">
                <button type="submit"
                        class="flex-1 md:flex-none bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-3.5 rounded-xl text-sm font-bold transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Guardar Pedido
                </button>
                <a href="{{ route('pedidos.index') }}"
                   class="flex-1 md:flex-none text-center border-2 border-gray-300 text-gray-700 hover:border-orange-500 hover:text-orange-500 px-8 py-3.5 rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancelar
                </a>
            </div>

        </form>
    </div>

    <script>
        // Toggle tipo de pago
        const estadoPago = document.getElementById('estado_pago');
        const tipoPagoField = document.getElementById('tipo-pago-field');

        function toggleTipoPago() {
            if (estadoPago.value === 'pagado') {
                tipoPagoField.classList.remove('hidden');
            } else {
                tipoPagoField.classList.add('hidden');
            }
        }

        estadoPago.addEventListener('change', toggleTipoPago);
        toggleTipoPago();

        // Marca y Modelo
        const marcaSelect = document.getElementById('marca');
        const marcaOtra = document.getElementById('marca_otra');
        const modeloSelect = document.getElementById('modelo');
        const modeloOtro = document.getElementById('modelo_otro');

        marcaSelect.addEventListener('change', async function() {
            const value = this.value;

            // Resetear todo
            modeloOtro.classList.add('hidden');
            modeloOtro.value = '';
            modeloOtro.removeAttribute('name');
            marcaOtra.classList.add('hidden');
            marcaOtra.value = '';
            marcaOtra.removeAttribute('name');

            // Si seleccionó "Otra marca"
            if (value === 'otra') {
                marcaOtra.classList.remove('hidden');
                marcaOtra.setAttribute('name', 'marca_otra');
                this.removeAttribute('name');
                modeloSelect.innerHTML = '<option value="">Primero complete la marca</option><option value="otro">➕ Otro modelo (escribir)</option>';
                modeloSelect.disabled = false;
                return;
            }

            // Restaurar name en marca
            this.setAttribute('name', 'marca_id');

            // Si no seleccionó nada
            if (!value) {
                modeloSelect.disabled = true;
                modeloSelect.innerHTML = '<option value="">Primero seleccione una marca</option>';
                return;
            }

            // Cargar modelos del catálogo vía AJAX
            modeloSelect.innerHTML = '<option value="">Cargando...</option>';
            modeloSelect.disabled = true;

            try {
                const response = await fetch(`/api/modelos/${value}`);
                const modelos = await response.json();

                modeloSelect.innerHTML = '<option value="">Seleccione un modelo</option>';

                modelos.forEach(modelo => {
                    const option = document.createElement('option');
                    option.value = modelo.id;
                    option.textContent = modelo.nombre;
                    modeloSelect.appendChild(option);
                });

                // SIEMPRE agregar opción "Otro"
                const optionOtro = document.createElement('option');
                optionOtro.value = 'otro';
                optionOtro.textContent = '➕ Otro modelo (escribir)';
                modeloSelect.appendChild(optionOtro);

                modeloSelect.disabled = false;
            } catch (error) {
                console.error('Error cargando modelos:', error);
                modeloSelect.innerHTML = '<option value="">Error al cargar modelos</option>';
            }
        });

        modeloSelect.addEventListener('change', function() {
            const selectedValue = this.value;

            if (selectedValue === 'otro') {
                // Mostrar input personalizado
                modeloOtro.classList.remove('hidden');
                modeloOtro.setAttribute('name', 'modelo_otro');
                // Quitar name del select y resetear
                this.removeAttribute('name');
                this.selectedIndex = 0;
            } else {
                // Usar modelo del catálogo
                modeloOtro.classList.add('hidden');
                modeloOtro.value = '';
                modeloOtro.removeAttribute('name');
                this.setAttribute('name', 'modelo_id');
            }
        });
    </script>

@endsection
