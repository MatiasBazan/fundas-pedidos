@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Stock</h1>
        <p class="text-sm text-gray-500 mt-0.5">Unidades disponibles por modelo y diseño</p>
    </div>
    <div class="flex items-center gap-3 text-xs">
        <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1.5 rounded-full font-semibold">
            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> +3
        </span>
        <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1.5 rounded-full font-semibold">
            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> 1–3
        </span>
        <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-1.5 rounded-full font-semibold">
            <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span> 0
        </span>
    </div>
</div>

{{-- Filtros --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-5">
    <form method="GET" action="{{ route('stock.index') }}">
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
                <a href="{{ route('stock.index') }}" class="px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-600 hover:text-gray-800 font-medium rounded-xl border border-gray-200 shadow-sm transition">✕</a>
            </div>
        </div>
    </form>
</div>

{{-- Mobile: cards --}}
<div class="block md:hidden space-y-3">
    @forelse($stocks as $stock)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-4 py-3.5 flex items-center justify-between">
            <div>
                <p class="font-semibold text-gray-900 text-sm">{{ $stock->nombre_disenio }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ $stock->modelo_celular }}</p>
            </div>
            @if($stock->cantidad > 3)
                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-1.5 rounded-full text-sm font-bold">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> {{ $stock->cantidad }}
                </span>
            @elseif($stock->cantidad >= 1)
                <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1.5 rounded-full text-sm font-bold">
                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> {{ $stock->cantidad }}
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-700 border border-rose-200 px-3 py-1.5 rounded-full text-sm font-bold">
                    <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span> Sin stock
                </span>
            @endif
        </div>
    @empty
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
            <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <p class="text-gray-400 text-sm">No hay registros de stock</p>
        </div>
    @endforelse
    @if($stocks->hasPages()) <div class="pt-2">{{ $stocks->links() }}</div> @endif
</div>

{{-- Desktop: table --}}
<div class="hidden md:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Modelo</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Diseño</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Cantidad</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Actualizado</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
        @forelse($stocks as $stock)
            <tr class="hover:bg-[#FFF0F5]/40 transition-colors">
                <td class="px-5 py-4 text-gray-400 text-xs font-mono">{{ $stock->id }}</td>
                <td class="px-5 py-4 text-gray-500">{{ $stock->modelo_celular }}</td>
                <td class="px-5 py-4 font-semibold text-gray-900">{{ $stock->nombre_disenio }}</td>
                <td class="px-5 py-4">
                    @if($stock->cantidad > 3)
                        <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full text-xs font-bold">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> {{ $stock->cantidad }} uds.
                        </span>
                    @elseif($stock->cantidad >= 1)
                        <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-full text-xs font-bold">
                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> {{ $stock->cantidad }} uds.
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-1 rounded-full text-xs font-bold">
                            <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span> Sin stock
                        </span>
                    @endif
                </td>
                <td class="px-5 py-4 text-gray-400 text-xs">{{ $stock->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-5 py-16 text-center">
                    <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <p class="text-gray-400 text-sm">No hay registros de stock</p>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @if($stocks->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">{{ $stocks->links() }}</div>
    @endif
</div>

@endsection
