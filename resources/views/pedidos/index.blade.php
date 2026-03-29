@extends('layouts.app')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Pedidos</h1>
        <a href="{{ route('pedidos.create') }}"
           class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
            + Nuevo pedido
        </a>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('pedidos.index') }}" class="bg-white rounded-lg shadow p-4 mb-6 flex gap-4 items-end flex-wrap">
        <div class="w-full sm:w-auto">
            <label class="block text-sm text-gray-600 mb-1">Estado del pedido</label>
            <select name="estado_pedido" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="">Todos</option>
                <option value="disponible" {{ request('estado_pedido') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="entregado"  {{ request('estado_pedido') == 'entregado'  ? 'selected' : '' }}>Entregado</option>
            </select>
        </div>
        <div class="w-full sm:w-auto">
            <label class="block text-sm text-gray-600 mb-1">Estado de pago</label>
            <select name="estado_pago" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="">Todos</option>
                <option value="pagado"    {{ request('estado_pago') == 'pagado'    ? 'selected' : '' }}>Pagado</option>
                <option value="no_pagado" {{ request('estado_pago') == 'no_pagado' ? 'selected' : '' }}>No pagado</option>
            </select>
        </div>
        <div class="w-full sm:w-auto">
            <label class="block text-sm text-gray-600 mb-1">Tipo de pago</label>
            <select name="tipo_pago" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="">Todos</option>
                <option value="efectivo"      {{ request('tipo_pago') == 'efectivo'      ? 'selected' : '' }}>Efectivo</option>
                <option value="transferencia" {{ request('tipo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
            </select>
        </div>
        <div class="flex gap-2 w-full sm:w-auto">
            <button type="submit"
                    class="flex-1 sm:flex-none bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                Filtrar
            </button>
            <a href="{{ route('pedidos.index') }}"
               class="flex-1 sm:flex-none text-center text-sm text-gray-500 hover:text-orange-500 border border-gray-300 px-4 py-2 rounded-lg transition">
                Limpiar
            </a>
        </div>
    </form>

    {{-- Total --}}
    <div class="bg-orange-50 border border-orange-200 rounded-lg px-5 py-4 mb-6 flex items-center justify-between">
        <p class="text-sm text-orange-700 font-medium">
            Total de pedidos mostrados: <span class="font-bold">{{ $pedidos->total() }}</span>
        </p>
        <p class="text-orange-700 font-bold text-lg">
            Total: ${{ number_format($total, 2, ',', '.') }}
        </p>
    </div>

    {{-- Vista mobile: tarjetas --}}
    <div class="block md:hidden space-y-4">
        @forelse($pedidos as $pedido)
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $pedido->nombre_disenio }}</p>
                        <p class="text-sm text-gray-500">{{ $pedido->marca }} - {{ $pedido->modelo }}</p>
                    </div>
                    <p class="text-orange-500 font-bold">${{ number_format($pedido->precio, 2, ',', '.') }}</p>
                </div>
                <p class="text-sm text-gray-600 mb-3">{{ $pedido->nombre }} {{ $pedido->apellido }}</p>
                <div class="flex gap-2 mb-3 flex-wrap">
                    @if($pedido->estado_pedido == 'disponible')
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-medium">Disponible</span>
                    @else
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-medium">Entregado</span>
                    @endif
                    @if($pedido->estado_pago == 'pagado')
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-medium">Pagado</span>
                        @if($pedido->tipo_pago == 'efectivo')
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-medium">Efectivo</span>
                        @else
                            <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full text-xs font-medium">Transferencia</span>
                        @endif
                    @else
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-medium">No pagado</span>
                    @endif
                </div>
                <div class="flex gap-3 border-t border-gray-100 pt-3">
                    <a href="{{ route('pedidos.show', $pedido) }}"
                       class="flex-1 text-center text-sm text-gray-600 hover:text-orange-500 transition">Ver</a>
                    <a href="{{ route('pedidos.edit', $pedido) }}"
                       class="flex-1 text-center text-sm text-gray-600 hover:text-orange-500 transition">Editar</a>
                    <form method="POST" action="{{ route('pedidos.destroy', $pedido) }}" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                                onclick="showDeleteModal(this.form, '{{ $pedido->nombre_disenio }}')"
                                class="w-full text-sm text-gray-600 hover:text-red-500 transition">Eliminar</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow p-8 text-center text-gray-400">
                No hay pedidos cargados.
            </div>
        @endforelse
    </div>

    {{-- Vista desktop: tabla --}}
    <div class="hidden md:block bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-orange-500 text-white">
            <tr>
                <th class="px-4 py-3 text-left">#</th>
                <th class="px-4 py-3 text-left">Diseño</th>
                <th class="px-4 py-3 text-left">Marca</th>
                <th class="px-4 py-3 text-left">Modelo</th>
                <th class="px-4 py-3 text-left">Cliente</th>
                <th class="px-4 py-3 text-left">Precio</th>
                <th class="px-4 py-3 text-left">Estado pedido</th>
                <th class="px-4 py-3 text-left">Estado pago</th>
                <th class="px-4 py-3 text-left">Tipo de pago</th>
                <th class="px-4 py-3 text-left">Acciones</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            @forelse($pedidos as $pedido)
                <tr class="hover:bg-orange-50 transition">
                    <td class="px-4 py-3 text-gray-500">{{ $pedido->id }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $pedido->nombre_disenio }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $pedido->marca }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $pedido->modelo }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $pedido->nombre }} {{ $pedido->apellido }}</td>
                    <td class="px-4 py-3 text-gray-800 font-medium">${{ number_format($pedido->precio, 2, ',', '.') }}</td>
                    <td class="px-4 py-3">
                        @if($pedido->estado_pedido == 'disponible')
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-medium">Disponible</span>
                        @else
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-medium">Entregado</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($pedido->estado_pago == 'pagado')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-medium">Pagado</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-medium">No pagado</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($pedido->estado_pago == 'pagado')
                            @if($pedido->tipo_pago == 'efectivo')
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-medium">Efectivo</span>
                            @else
                                <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full text-xs font-medium">Transferencia</span>
                            @endif
                        @else
                            <span class="text-gray-300 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('pedidos.show', $pedido) }}"
                               class="text-gray-500 hover:text-orange-500 transition" title="Ver">👁</a>
                            <a href="{{ route('pedidos.edit', $pedido) }}"
                               class="text-gray-500 hover:text-orange-500 transition" title="Editar">✏️</a>
                            <form method="POST" action="{{ route('pedidos.destroy', $pedido) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="showDeleteModal(this.form, '{{ $pedido->nombre_disenio }}')"
                                        class="text-gray-500 hover:text-red-500 transition" title="Eliminar">🗑</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="px-4 py-8 text-center text-gray-400">No hay pedidos cargados.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        @if($pedidos->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $pedidos->links() }}
            </div>
        @endif
    </div>

    {{-- Modal de confirmación --}}
    <x-delete-modal />

@endsection
