@extends('layouts.app')

@section('content')

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Stock</h1>
        <p class="text-gray-600 mt-1">Unidades disponibles por modelo y diseño</p>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('stock.index') }}" class="bg-white rounded-xl shadow-md p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Modelo de celular</label>
                <input type="text" name="modelo_celular" value="{{ request('modelo_celular') }}"
                       placeholder="Ej: iPhone 14..."
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre de diseño</label>
                <input type="text" name="nombre_disenio" value="{{ request('nombre_disenio') }}"
                       placeholder="Ej: Flores..."
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
            </div>
            <div class="flex gap-2">
                <button type="submit"
                        class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition shadow-sm hover:shadow-md">
                    Filtrar
                </button>
                <a href="{{ route('stock.index') }}"
                   class="flex-1 text-center text-sm font-semibold text-gray-600 hover:text-orange-500 border-2 border-gray-300 hover:border-orange-500 px-5 py-2.5 rounded-lg transition">
                    Limpiar
                </a>
            </div>
        </div>
    </form>

    {{-- Leyenda --}}
    <div class="flex items-center gap-4 mb-4 flex-wrap">
        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Leyenda:</span>
        <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-xs font-semibold px-3 py-1.5 rounded-full">
            <span class="w-2 h-2 bg-green-500 rounded-full"></span> Disponible (más de 3)
        </span>
        <span class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1.5 rounded-full">
            <span class="w-2 h-2 bg-yellow-500 rounded-full"></span> Bajo (1 – 3)
        </span>
        <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs font-semibold px-3 py-1.5 rounded-full">
            <span class="w-2 h-2 bg-red-500 rounded-full"></span> Sin stock (0)
        </span>
    </div>

    {{-- Vista mobile: tarjetas --}}
    <div class="block md:hidden space-y-3">
        @forelse($stocks as $stock)
            <div class="bg-white rounded-xl shadow-md p-5 flex justify-between items-center">
                <div>
                    <p class="font-bold text-gray-800">{{ $stock->nombre_disenio }}</p>
                    <p class="text-sm text-gray-500 mt-0.5">{{ $stock->modelo_celular }}</p>
                </div>
                @if($stock->cantidad > 3)
                    <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-sm font-bold px-3 py-1.5 rounded-full">
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                        {{ $stock->cantidad }}
                    </span>
                @elseif($stock->cantidad >= 1)
                    <span class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-700 text-sm font-bold px-3 py-1.5 rounded-full">
                        <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                        {{ $stock->cantidad }}
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-sm font-bold px-3 py-1.5 rounded-full">
                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        {{ $stock->cantidad }}
                    </span>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <p class="text-gray-400 font-medium">No hay registros de stock</p>
            </div>
        @endforelse
        @if($stocks->hasPages())
            <div class="pt-4">{{ $stocks->links() }}</div>
        @endif
    </div>

    {{-- Vista desktop: tabla --}}
    <div class="hidden md:block bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead>
            <tr class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                <th class="px-6 py-4 text-left font-semibold">#</th>
                <th class="px-6 py-4 text-left font-semibold">Modelo de celular</th>
                <th class="px-6 py-4 text-left font-semibold">Nombre de diseño</th>
                <th class="px-6 py-4 text-left font-semibold">Cantidad disponible</th>
                <th class="px-6 py-4 text-left font-semibold">Actualizado</th>
            </tr>
            </thead>
            <tbody>
            @forelse($stocks as $stock)
                <tr class="border-b border-gray-100 hover:bg-orange-50 transition-colors">
                    <td class="px-6 py-4 text-gray-500 font-medium">{{ $stock->id }}</td>
                    <td class="px-6 py-4 text-gray-700 font-medium">{{ $stock->modelo_celular }}</td>
                    <td class="px-6 py-4 font-bold text-gray-800">{{ $stock->nombre_disenio }}</td>
                    <td class="px-6 py-4">
                        @if($stock->cantidad > 3)
                            <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-sm font-bold px-3 py-1.5 rounded-full">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                {{ $stock->cantidad }} uds.
                            </span>
                        @elseif($stock->cantidad >= 1)
                            <span class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-700 text-sm font-bold px-3 py-1.5 rounded-full">
                                <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                                {{ $stock->cantidad }} uds.
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-sm font-bold px-3 py-1.5 rounded-full">
                                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                Sin stock
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-xs">{{ $stock->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <p class="text-gray-400 font-medium">No hay registros de stock</p>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        @if($stocks->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $stocks->links() }}
            </div>
        @endif
    </div>

@endsection
