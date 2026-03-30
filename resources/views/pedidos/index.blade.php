@extends('layouts.app')

@section('content')

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Pedidos</h1>
        <p class="text-gray-600 mt-1">Gestiona todos tus pedidos de fundas</p>
    </div>

    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('pedidos.create') }}"
           class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Nuevo pedido
        </a>
        <a href="{{ route('pedidos.export') }}?{{ http_build_query(request()->only(['estado_pedido', 'estado_pago', 'tipo_pago', 'buscar'])) }}"
           class="bg-white border-2 border-gray-300 hover:border-orange-500 hover:text-orange-600 text-gray-600 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Exportar CSV
        </a>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('pedidos.index') }}" class="bg-white rounded-xl shadow-md p-6 mb-6">
        <div class="space-y-4">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Buscar</label>
            <input type="text" name="buscar" value="{{ request('buscar') }}"
                   placeholder="Nombre, apellido, diseño, marca o modelo..."
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Estado del pedido</label>
                <select name="estado_pedido" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                    <option value="">Todos</option>
                    <option value="disponible" {{ request('estado_pedido') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="entregado"  {{ request('estado_pedido') == 'entregado'  ? 'selected' : '' }}>Entregado</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Estado de pago</label>
                <select name="estado_pago" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                    <option value="">Todos</option>
                    <option value="pagado"    {{ request('estado_pago') == 'pagado'    ? 'selected' : '' }}>Pagado</option>
                    <option value="no_pagado" {{ request('estado_pago') == 'no_pagado' ? 'selected' : '' }}>No pagado</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tipo de pago</label>
                <select name="tipo_pago" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                    <option value="">Todos</option>
                    <option value="efectivo"      {{ request('tipo_pago') == 'efectivo'      ? 'selected' : '' }}>Efectivo</option>
                    <option value="transferencia" {{ request('tipo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit"
                        class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition shadow-sm hover:shadow-md">
                    Filtrar
                </button>
                <a href="{{ route('pedidos.index') }}"
                   class="flex-1 text-center text-sm font-semibold text-gray-600 hover:text-orange-500 border-2 border-gray-300 hover:border-orange-500 px-5 py-2.5 rounded-lg transition">
                    Limpiar
                </a>
            </div>
        </div>
        </div>
    </form>

    {{-- Total --}}
    <div class="bg-gradient-to-r from-orange-50 to-orange-100 border-2 border-orange-200 rounded-xl px-6 py-5 mb-6 shadow-sm">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <div class="bg-orange-500 p-2 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <p class="text-sm text-orange-800 font-medium">
                    Total de pedidos mostrados: <span class="font-bold text-lg">{{ $pedidos->total() }}</span>
                </p>
            </div>
            <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-lg shadow-sm">
                <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-orange-700 font-bold text-xl">
                    ${{ number_format($total, 2, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- Vista mobile: tarjetas --}}
    <div class="block md:hidden space-y-4">
        @forelse($pedidos as $pedido)
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-5">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <p class="font-bold text-gray-800 text-lg">{{ $pedido->nombre_disenio }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $pedido->marca }} - {{ $pedido->modelo }}</p>
                    </div>
                    <div class="bg-orange-100 px-3 py-1.5 rounded-lg">
                        <p class="text-orange-700 font-bold">${{ number_format($pedido->precio, 2, ',', '.') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm text-gray-600 font-medium">{{ $pedido->nombre }} {{ $pedido->apellido }}</p>
                </div>
                <div class="flex gap-2 mb-4 flex-wrap">
                    <x-badge-estado-pedido :estado="$pedido->estado_pedido" />
                    <x-badge-estado-pago :estado="$pedido->estado_pago" />
                    @if($pedido->estado_pago === 'pagado')
                        <x-badge-tipo-pago :tipo="$pedido->tipo_pago" />
                    @endif
                </div>
                <div class="flex gap-2 border-t border-gray-100 pt-3">
                    <a href="{{ route('pedidos.show', $pedido) }}"
                       class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm font-medium transition">
                        Ver
                    </a>
                    <a href="{{ route('pedidos.edit', $pedido) }}"
                       class="flex-1 text-center bg-orange-100 hover:bg-orange-200 text-orange-700 px-3 py-2 rounded-lg text-sm font-medium transition">
                        Editar
                    </a>
                    <form method="POST" action="{{ route('pedidos.destroy', $pedido) }}" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                                onclick="showDeleteModal(this.form, '{{ $pedido->nombre_disenio }}')"
                                class="w-full bg-red-100 hover:bg-red-200 text-red-700 px-3 py-2 rounded-lg text-sm font-medium transition">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="text-gray-400 font-medium">No hay pedidos cargados</p>
            </div>
        @endforelse
        @if($pedidos->hasPages())
            <div class="pt-4">
                {{ $pedidos->links() }}
            </div>
        @endif
    </div>

    {{-- Vista desktop: tabla --}}
    <div class="hidden md:block bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead>
            <tr class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                <th class="px-6 py-4 text-left font-semibold">#</th>
                <th class="px-6 py-4 text-left font-semibold">Diseño</th>
                <th class="px-6 py-4 text-left font-semibold">Marca</th>
                <th class="px-6 py-4 text-left font-semibold">Modelo</th>
                <th class="px-6 py-4 text-left font-semibold">Cliente</th>
                <th class="px-6 py-4 text-left font-semibold">Precio</th>
                <th class="px-6 py-4 text-left font-semibold">Estado pedido</th>
                <th class="px-6 py-4 text-left font-semibold">Estado pago</th>
                <th class="px-6 py-4 text-left font-semibold">Tipo de pago</th>
                <th class="px-6 py-4 text-left font-semibold">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($pedidos as $pedido)
                <tr class="border-b border-gray-100 hover:bg-orange-50 transition-colors">
                    <td class="px-6 py-4 text-gray-500 font-medium">{{ $pedido->id }}</td>
                    <td class="px-6 py-4 font-bold text-gray-800">{{ $pedido->nombre_disenio }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $pedido->marca }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $pedido->modelo }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $pedido->nombre }} {{ $pedido->apellido }}</td>
                    <td class="px-6 py-4 text-gray-900 font-bold">${{ number_format($pedido->precio, 2, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <x-badge-estado-pedido :estado="$pedido->estado_pedido" />
                    </td>
                    <td class="px-6 py-4">
                        <x-badge-estado-pago :estado="$pedido->estado_pago" />
                    </td>
                    <td class="px-6 py-4">
                        <x-badge-tipo-pago :tipo="$pedido->tipo_pago" />
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('pedidos.show', $pedido) }}"
                               class="p-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg transition" title="Ver">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('pedidos.edit', $pedido) }}"
                               class="p-2 bg-orange-100 hover:bg-orange-200 text-orange-600 rounded-lg transition" title="Editar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('pedidos.destroy', $pedido) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="showDeleteModal(this.form, '{{ $pedido->nombre_disenio }}')"
                                        class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition" title="Eliminar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="px-6 py-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="text-gray-400 font-medium">No hay pedidos cargados</p>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        @if($pedidos->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $pedidos->links() }}
            </div>
        @endif
    </div>

    {{-- Modal de confirmación --}}
    <x-delete-modal />

@endsection
