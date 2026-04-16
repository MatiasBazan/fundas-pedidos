@extends('layouts.app')

@section('content')

{{-- Page header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pedidos</h1>
        <p class="text-sm text-gray-500 mt-0.5">Gestión de pedidos de fundas</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('pedidos.export') }}?{{ http_build_query(request()->only(['estado_pedido','estado_pago','tipo_pago','buscar'])) }}"
           class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-600 hover:border-[#FF2D6B] hover:text-[#E0245E] rounded-xl text-sm font-medium transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Exportar
        </a>
        <a href="{{ route('pedidos.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-[#FF2D6B] hover:bg-[#E0245E] text-white rounded-xl text-sm font-semibold transition-all shadow-sm shadow-[#FF2D6B]/30">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Nuevo pedido
        </a>
    </div>
</div>

{{-- Filtros --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-5">
    <form method="GET" action="{{ route('pedidos.index') }}">
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Buscar</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                    </svg>
                    <input type="text" name="buscar" value="{{ request('buscar') }}"
                           placeholder="Nombre, apellido, diseño, marca o modelo..."
                           class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all">
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Estado pedido</label>
                    <select name="estado_pedido" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all bg-white">
                        <option value="">Todos</option>
                        <option value="disponible" {{ request('estado_pedido') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="entregado"  {{ request('estado_pedido') == 'entregado'  ? 'selected' : '' }}>Entregado</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Estado pago</label>
                    <select name="estado_pago" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all bg-white">
                        <option value="">Todos</option>
                        <option value="pagado"    {{ request('estado_pago') == 'pagado'    ? 'selected' : '' }}>Pagado</option>
                        <option value="no_pagado" {{ request('estado_pago') == 'no_pagado' ? 'selected' : '' }}>No pagado</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tipo pago</label>
                    <select name="tipo_pago" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all bg-white">
                        <option value="">Todos</option>
                        <option value="efectivo"      {{ request('tipo_pago') == 'efectivo'      ? 'selected' : '' }}>Efectivo</option>
                        <option value="transferencia" {{ request('tipo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 bg-[#FF2D6B] hover:bg-[#E0245E] text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-all">
                        Filtrar
                    </button>
                    <a href="{{ route('pedidos.index') }}" class="px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-600 hover:text-gray-800 font-medium rounded-xl border border-gray-200 shadow-sm transition">
                        ✕
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Summary bar --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4 mb-5 flex items-center justify-between flex-wrap gap-3">
    <span class="text-sm text-gray-500">
        <span class="font-bold text-gray-900 text-lg">{{ $pedidos->total() }}</span> pedidos encontrados
    </span>
    <div class="flex items-center gap-2">
        <span class="text-xs text-gray-400 uppercase tracking-wide font-semibold">Total</span>
        <span class="text-xl font-bold text-[#FF2D6B]">${{ number_format($total, 2, ',', '.') }}</span>
    </div>
</div>

{{-- Mobile: cards --}}
<div class="block md:hidden space-y-3">
    @forelse($pedidos as $pedido)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="font-bold text-gray-900">{{ $pedido->nombre_disenio }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $pedido->marca }} · {{ $pedido->modelo }}</p>
                </div>
                <span class="text-[#FF2D6B] font-bold text-sm">${{ number_format($pedido->precio, 2, ',', '.') }}</span>
            </div>
            <p class="text-xs text-gray-500 mb-3">{{ $pedido->nombre }} {{ $pedido->apellido }}</p>
            <div class="flex flex-wrap gap-1.5 mb-3">
                <x-badge-estado-pedido :estado="$pedido->estado_pedido" />
                <x-badge-estado-pago :estado="$pedido->estado_pago" />
                @if($pedido->estado_pago === 'pagado')
                    <x-badge-tipo-pago :tipo="$pedido->tipo_pago" />
                @endif
            </div>
            <div class="flex gap-2 pt-3 border-t border-gray-100">
                <a href="{{ route('pedidos.show', $pedido) }}" class="flex-1 text-center py-2 text-xs font-semibold text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">Ver</a>
                <a href="{{ route('pedidos.edit', $pedido) }}" class="flex-1 text-center py-2 text-xs font-semibold text-[#FF2D6B] bg-[#FFF0F5] hover:bg-[#FFD6E5] rounded-lg transition-colors">Editar</a>
                <form method="POST" action="{{ route('pedidos.destroy', $pedido) }}" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="button" onclick="showDeleteModal(this.form, '{{ $pedido->nombre_disenio }}')"
                            class="w-full py-2 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">Eliminar</button>
                </form>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
            <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="text-gray-400 text-sm">No hay pedidos cargados</p>
        </div>
    @endforelse
    @if($pedidos->hasPages())
        <div class="pt-2">{{ $pedidos->links() }}</div>
    @endif
</div>

{{-- Desktop: table --}}
<div class="hidden md:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Diseño</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Dispositivo</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Cliente</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Precio</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Pedido</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Pago</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Tipo</th>
                <th class="px-5 py-3.5 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
        @forelse($pedidos as $pedido)
            <tr class="hover:bg-[#FFF0F5]/40 transition-colors">
                <td class="px-5 py-4 text-gray-400 text-xs font-mono">{{ $pedido->id }}</td>
                <td class="px-5 py-4 font-semibold text-gray-900">{{ $pedido->nombre_disenio }}</td>
                <td class="px-5 py-4 text-gray-500">{{ $pedido->marca }}<span class="text-gray-300 mx-1">·</span>{{ $pedido->modelo }}</td>
                <td class="px-5 py-4 text-gray-600">{{ $pedido->nombre }} {{ $pedido->apellido }}</td>
                <td class="px-5 py-4 font-bold text-gray-900">${{ number_format($pedido->precio, 2, ',', '.') }}</td>
                <td class="px-5 py-4"><x-badge-estado-pedido :estado="$pedido->estado_pedido" /></td>
                <td class="px-5 py-4"><x-badge-estado-pago :estado="$pedido->estado_pago" /></td>
                <td class="px-5 py-4"><x-badge-tipo-pago :tipo="$pedido->tipo_pago" /></td>
                <td class="px-5 py-4">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('pedidos.show', $pedido) }}"
                           class="p-1.5 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors" title="Ver">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                        <a href="{{ route('pedidos.edit', $pedido) }}"
                           class="p-1.5 text-gray-400 hover:text-[#E0245E] hover:bg-[#FFF0F5] rounded-lg transition-colors" title="Editar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('pedidos.destroy', $pedido) }}">
                            @csrf @method('DELETE')
                            <button type="button"
                                    onclick="showDeleteModal(this.form, '{{ $pedido->nombre_disenio }}')"
                                    class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="px-5 py-16 text-center">
                    <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-gray-400 text-sm">No hay pedidos cargados</p>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @if($pedidos->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">{{ $pedidos->links() }}</div>
    @endif
</div>

<x-delete-modal />

@endsection
