@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Compras</h1>
        <p class="text-sm text-gray-500 mt-0.5">Compras al mayorista</p>
    </div>
    <a href="{{ route('compras.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-[#FF2D6B] hover:bg-[#E0245E] text-white rounded-xl text-sm font-semibold transition-all shadow-sm shadow-[#FF2D6B]/30">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Nueva compra
    </a>
</div>

{{-- Filtros --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-5">
    <form method="GET" action="{{ route('compras.index') }}">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Modelo</label>
                <input type="text" name="modelo_celular" value="{{ request('modelo_celular') }}" placeholder="Ej: iPhone 14..."
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Diseño</label>
                <input type="text" name="nombre_disenio" value="{{ request('nombre_disenio') }}" placeholder="Ej: Flores..."
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-[#FF2D6B] hover:bg-[#E0245E] text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-all">Filtrar</button>
                <a href="{{ route('compras.index') }}" class="px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-600 hover:text-gray-800 font-medium rounded-xl border border-gray-200 shadow-sm transition">✕</a>
            </div>
        </div>
    </form>
</div>

{{-- Totales --}}
<div class="grid grid-cols-2 gap-4 mb-5">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
        <div class="w-10 h-10 bg-[#FFD6E5] rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-[#FF2D6B]" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Unidades totales</p>
            <p class="text-xl font-bold text-gray-900">{{ number_format($totalUnidades) }}</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
        <div class="w-10 h-10 bg-[#FFD6E5] rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-[#FF2D6B]" fill="currentColor" viewBox="0 0 20 20">
                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total invertido</p>
            <p class="text-xl font-bold text-gray-900">${{ number_format($totalInvertido, 2, ',', '.') }}</p>
        </div>
    </div>
</div>

{{-- Mobile: cards --}}
<div class="block md:hidden space-y-3">
    @forelse($compras as $compra)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="font-bold text-gray-900">Compra #{{ $compra->id }}</p>
                    <p class="text-xs text-gray-400">{{ $compra->fecha->format('d/m/Y') }}</p>
                </div>
                <span class="text-[#FF2D6B] font-bold text-sm">${{ number_format($compra->items_sum_precio_total ?? 0, 2, ',', '.') }}</span>
            </div>
            <p class="text-xs text-gray-500">{{ $compra->items_count }} {{ Str::plural('item', $compra->items_count) }} · {{ number_format($compra->items_sum_cantidad ?? 0) }} uds.</p>
            @if($compra->observaciones)
                <p class="text-xs text-gray-400 mt-1 truncate">{{ $compra->observaciones }}</p>
            @endif
            <div class="flex gap-2 pt-3 mt-3 border-t border-gray-100">
                <a href="{{ route('compras.show', $compra) }}" class="flex-1 text-center py-2 text-xs font-semibold text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">Ver</a>
                <a href="{{ route('compras.edit', $compra) }}" class="flex-1 text-center py-2 text-xs font-semibold text-[#FF2D6B] bg-[#FFF0F5] hover:bg-[#FFD6E5] rounded-lg transition-colors">Editar</a>
                <form method="POST" action="{{ route('compras.destroy', $compra) }}" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="button" onclick="showDeleteModal(this.closest('form'), 'Compra #{{ $compra->id }}')"
                            class="w-full py-2 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">Eliminar</button>
                </form>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
            <p class="text-gray-400 text-sm">No hay compras registradas</p>
        </div>
    @endforelse
    @if($compras->hasPages()) <div class="pt-2">{{ $compras->links() }}</div> @endif
</div>

{{-- Desktop: table --}}
<div class="hidden md:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Fecha</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Items</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Unidades</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Total</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Observaciones</th>
                <th class="px-5 py-3.5 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
        @forelse($compras as $compra)
            <tr class="hover:bg-[#FFF0F5]/40 transition-colors">
                <td class="px-5 py-4 text-gray-400 text-xs font-mono">{{ $compra->id }}</td>
                <td class="px-5 py-4 text-gray-600 text-sm">{{ $compra->fecha->format('d/m/Y') }}</td>
                <td class="px-5 py-4">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-[#FFD6E5] text-[#9B0035]">
                        {{ $compra->items_count }} {{ Str::plural('item', $compra->items_count) }}
                    </span>
                </td>
                <td class="px-5 py-4 text-gray-600">{{ number_format($compra->items_sum_cantidad ?? 0) }} uds.</td>
                <td class="px-5 py-4 font-bold text-gray-900">${{ number_format($compra->items_sum_precio_total ?? 0, 2, ',', '.') }}</td>
                <td class="px-5 py-4 text-gray-400 text-xs max-w-xs truncate">{{ $compra->observaciones ?? '—' }}</td>
                <td class="px-5 py-4">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('compras.show', $compra) }}" class="p-1.5 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        <a href="{{ route('compras.edit', $compra) }}" class="p-1.5 text-gray-400 hover:text-[#E0245E] hover:bg-[#FFF0F5] rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('compras.destroy', $compra) }}">
                            @csrf @method('DELETE')
                            <button type="button" onclick="showDeleteModal(this.closest('form'), 'Compra #{{ $compra->id }}')"
                                    class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-5 py-16 text-center">
                    <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <p class="text-gray-400 text-sm">No hay compras registradas</p>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @if($compras->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">{{ $compras->links() }}</div>
    @endif
</div>

@endsection
