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
        <h1 class="text-3xl font-bold text-gray-800 mt-2">Detalle del Pedido #{{ $pedido->id }}</h1>
        <p class="text-gray-600 mt-1">Información completa del pedido</p>
    </div>

    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow max-w-3xl mx-auto">
        <!-- Header del pedido -->
        <div class="bg-gradient-to-r from-purple-50 to-purple-100 border-b border-purple-200 px-8 py-6 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-purple-500 p-3 rounded-xl shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $pedido->nombre_disenio }}</h2>
                        <p class="text-sm text-gray-600">Pedido #{{ $pedido->id }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 uppercase font-medium">Precio</p>
                    <p class="text-orange-600 font-bold text-2xl">${{ number_format($pedido->precio, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <!-- Dispositivo -->
            <div class="bg-gray-50 rounded-xl p-6 border-2 border-gray-100 mb-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <rect x="7" y="2" width="10" height="20" rx="2"></rect>
                        <circle cx="12" cy="18" r="1"></circle>
                    </svg>
                    Dispositivo
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Marca</p>
                        <p class="text-gray-900 font-medium">{{ $pedido->marca }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Modelo</p>
                        <p class="text-gray-900 font-medium">{{ $pedido->modelo }}</p>
                    </div>
                </div>
            </div>

            <!-- Cliente -->
            <div class="bg-purple-50 rounded-xl p-6 border-2 border-purple-100 mb-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    Información del Cliente
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Nombre</p>
                        <p class="text-gray-900 font-medium">{{ $pedido->nombre }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Apellido</p>
                        <p class="text-gray-900 font-medium">{{ $pedido->apellido }}</p>
                    </div>
                </div>
            </div>

            <!-- Estados -->
            <div class="bg-amber-50 rounded-xl p-6 border-2 border-amber-100 mb-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    Estados y Pagos
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-2">Estado del pedido</p>
                        @if($pedido->estado_pedido == 'disponible')
                            <span class="inline-flex items-center bg-blue-100 text-blue-700 px-3 py-1.5 rounded-full text-sm font-semibold">
                                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                Disponible
                            </span>
                        @else
                            <span class="inline-flex items-center bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-sm font-semibold">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                Entregado
                            </span>
                        @endif
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-2">Estado de pago</p>
                        @if($pedido->estado_pago == 'pagado')
                            <span class="inline-flex items-center bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-sm font-semibold">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                Pagado
                            </span>
                        @else
                            <span class="inline-flex items-center bg-red-100 text-red-700 px-3 py-1.5 rounded-full text-sm font-semibold">
                                <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                No pagado
                            </span>
                        @endif
                    </div>

                    @if($pedido->estado_pago == 'pagado')
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold mb-2">Tipo de pago</p>
                            @if($pedido->tipo_pago == 'efectivo')
                                <span class="inline-flex items-center bg-yellow-100 text-yellow-700 px-3 py-1.5 rounded-full text-sm font-semibold">
                                    <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                    Efectivo
                                </span>
                            @else
                                <span class="inline-flex items-center bg-purple-100 text-purple-700 px-3 py-1.5 rounded-full text-sm font-semibold">
                                    <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
                                    Transferencia
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Fecha de carga -->
            <div class="bg-blue-50 rounded-xl p-6 border-2 border-blue-100">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-500 p-2.5 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-0.5">Fecha de Carga</p>
                        <p class="text-gray-900 font-bold">{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="bg-gray-50 px-8 py-6 rounded-b-xl border-t-2 border-gray-100">
            <div class="flex gap-3">
                <a href="{{ route('pedidos.edit', $pedido) }}"
                   class="flex-1 md:flex-none bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-3.5 rounded-xl text-sm font-bold transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar Pedido
                </a>
                <form method="POST" action="{{ route('pedidos.destroy', $pedido) }}">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            onclick="showDeleteModal(this.form, '{{ $pedido->nombre_disenio }}')"
                            class="flex-1 md:flex-none border-2 border-red-300 text-red-600 hover:bg-red-50 px-8 py-3.5 rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal de confirmación --}}
    <x-delete-modal />

@endsection
