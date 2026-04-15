@extends('layouts.app')

@section('content')

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Compras al mayorista</h1>
        <p class="text-gray-600 mt-1">Registrá tus compras de fundas al por mayor</p>
    </div>

    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('compras.create') }}"
           class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Nueva compra
        </a>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('compras.index') }}" class="bg-white rounded-xl shadow-md p-6 mb-6">
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
                <a href="{{ route('compras.index') }}"
                   class="flex-1 text-center text-sm font-semibold text-gray-600 hover:text-orange-500 border-2 border-gray-300 hover:border-orange-500 px-5 py-2.5 rounded-lg transition">
                    Limpiar
                </a>
            </div>
        </div>
    </form>

    {{-- Totales --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-gradient-to-r from-orange-50 to-orange-100 border-2 border-orange-200 rounded-xl px-6 py-5 shadow-sm flex items-center gap-3">
            <div class="bg-orange-500 p-2 rounded-lg">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-orange-700 font-medium uppercase tracking-wide">Total unidades</p>
                <p class="text-2xl font-bold text-orange-800">{{ number_format($totalUnidades) }}</p>
            </div>
        </div>
        <div class="bg-gradient-to-r from-orange-50 to-orange-100 border-2 border-orange-200 rounded-xl px-6 py-5 shadow-sm flex items-center gap-3">
            <div class="bg-orange-500 p-2 rounded-lg">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-orange-700 font-medium uppercase tracking-wide">Total invertido</p>
                <p class="text-2xl font-bold text-orange-800">${{ number_format($totalInvertido, 2, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Vista mobile: tarjetas --}}
    <div class="block md:hidden space-y-4">
        @forelse($compras as $compra)
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-5">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <p class="font-bold text-gray-800 text-lg">{{ $compra->nombre_disenio }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $compra->modelo_celular }}</p>
                    </div>
                    <div class="bg-orange-100 px-3 py-1.5 rounded-lg text-right">
                        <p class="text-orange-700 font-bold">${{ number_format($compra->precio_total, 2, ',', '.') }}</p>
                        <p class="text-xs text-orange-500">{{ $compra->cantidad }} uds.</p>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mb-4">{{ $compra->created_at->format('d/m/Y') }}</p>
                <div class="flex gap-2 border-t border-gray-100 pt-3">
                    <a href="{{ route('compras.show', $compra) }}"
                       class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm font-medium transition">
                        Ver
                    </a>
                    <a href="{{ route('compras.edit', $compra) }}"
                       class="flex-1 text-center bg-orange-100 hover:bg-orange-200 text-orange-700 px-3 py-2 rounded-lg text-sm font-medium transition">
                        Editar
                    </a>
                    <form method="POST" action="{{ route('compras.destroy', $compra) }}" class="flex-1"
                          onsubmit="return confirm('¿Eliminar esta compra?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full bg-red-100 hover:bg-red-200 text-red-700 px-3 py-2 rounded-lg text-sm font-medium transition">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <p class="text-gray-400 font-medium">No hay compras registradas</p>
            </div>
        @endforelse
        @if($compras->hasPages())
            <div class="pt-4">{{ $compras->links() }}</div>
        @endif
    </div>

    {{-- Vista desktop: tabla --}}
    <div class="hidden md:block bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead>
            <tr class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                <th class="px-6 py-4 text-left font-semibold">#</th>
                <th class="px-6 py-4 text-left font-semibold">Modelo</th>
                <th class="px-6 py-4 text-left font-semibold">Diseño</th>
                <th class="px-6 py-4 text-left font-semibold">Cantidad</th>
                <th class="px-6 py-4 text-left font-semibold">P. Unitario</th>
                <th class="px-6 py-4 text-left font-semibold">P. Total</th>
                <th class="px-6 py-4 text-left font-semibold">Fecha</th>
                <th class="px-6 py-4 text-left font-semibold">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($compras as $compra)
                <tr class="border-b border-gray-100 hover:bg-orange-50 transition-colors">
                    <td class="px-6 py-4 text-gray-500 font-medium">{{ $compra->id }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $compra->modelo_celular }}</td>
                    <td class="px-6 py-4 font-bold text-gray-800">{{ $compra->nombre_disenio }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ number_format($compra->cantidad) }}</td>
                    <td class="px-6 py-4 text-gray-700">${{ number_format($compra->precio_unitario, 2, ',', '.') }}</td>
                    <td class="px-6 py-4 text-gray-900 font-bold">${{ number_format($compra->precio_total, 2, ',', '.') }}</td>
                    <td class="px-6 py-4 text-gray-500 text-xs">{{ $compra->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('compras.show', $compra) }}"
                               class="p-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg transition" title="Ver">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('compras.edit', $compra) }}"
                               class="p-2 bg-orange-100 hover:bg-orange-200 text-orange-600 rounded-lg transition" title="Editar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('compras.destroy', $compra) }}"
                                  onsubmit="return confirm('¿Eliminar esta compra?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
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
                    <td colspan="8" class="px-6 py-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <p class="text-gray-400 font-medium">No hay compras registradas</p>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        @if($compras->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $compras->links() }}
            </div>
        @endif
    </div>

@endsection
