@extends('layouts.app')

@section('content')

<div class="mb-6">
    <a href="{{ route('pedidos.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-[#FF2D6B] transition-colors mb-3">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver a Ventas
    </a>
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Venta #{{ $pedido->id }}</h1>
            <p class="text-sm text-gray-500 mt-0.5">{{ $pedido->nombre }} {{ $pedido->apellido }} · {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <span class="text-2xl font-bold text-[#FF2D6B] flex-shrink-0">${{ number_format($pedido->precio_total, 2, ',', '.') }}</span>
    </div>
</div>

<div class="max-w-3xl space-y-4">

    {{-- Productos --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50">
            <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                <span class="w-1 h-4 bg-[#FF2D6B] rounded-full"></span>
                Productos
            </h2>
        </div>
        <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-50">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Producto</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Cant.</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">P. Unit.</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($pedido->items as $item)
                    <tr>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $item->nombre_disenio }}</p>
                            @if($item->modelo_celular)
                                <p class="text-xs text-gray-400 mt-0.5">{{ $item->modelo_celular }}</p>
                            @else
                                <span class="text-xs bg-blue-50 text-blue-500 px-1.5 py-0.5 rounded font-medium">Accesorio</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center text-gray-600">{{ $item->cantidad }}</td>
                        <td class="px-6 py-4 text-right text-gray-600">${{ number_format($item->precio_unitario, 2, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right font-bold text-gray-900">${{ number_format($item->precio_total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-[#FFF0F5] border-t border-[#FFD6E5]">
                    <td colspan="3" class="px-6 py-3 text-sm font-semibold text-gray-600 text-right">Total</td>
                    <td class="px-6 py-3 text-right font-bold text-[#FF2D6B]">${{ number_format($pedido->precio_total, 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
        </div>
    </div>

    {{-- Cliente --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50">
            <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                <span class="w-1 h-4 bg-[#FF2D6B] rounded-full"></span>
                Cliente
            </h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-gray-50">
            <div class="px-6 py-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Nombre</p>
                <p class="text-gray-900 font-medium">{{ $pedido->nombre }}</p>
            </div>
            <div class="px-6 py-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Apellido</p>
                <p class="text-gray-900 font-medium">{{ $pedido->apellido }}</p>
            </div>
        </div>
    </div>

    {{-- Estados --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50">
            <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                <span class="w-1 h-4 bg-[#FF2D6B] rounded-full"></span>
                Estados
            </h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-gray-50">
            <div class="px-6 py-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Pedido</p>
                <x-badge-estado-pedido :estado="$pedido->estado_pedido" />
            </div>
            <div class="px-6 py-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Pago</p>
                <x-badge-estado-pago :estado="$pedido->estado_pago" />
            </div>
            @if($pedido->estado_pago == 'pagado')
            <div class="px-6 py-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Tipo</p>
                <x-badge-tipo-pago :tipo="$pedido->tipo_pago" />
            </div>
            @endif
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('pedidos.edit', $pedido) }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#FF2D6B] hover:bg-[#E0245E] text-white rounded-xl text-sm font-semibold transition-all shadow-sm shadow-[#FF2D6B]/30">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Editar
        </a>
        <form method="POST" action="{{ route('pedidos.destroy', $pedido) }}">
            @csrf @method('DELETE')
            <button type="button" onclick="showDeleteModal(this.form, 'Pedido #{{ $pedido->id }}')"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-white hover:bg-red-50 text-red-500 hover:text-red-600 font-medium rounded-xl border border-red-200 shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Eliminar
            </button>
        </form>
        <a href="{{ route('pedidos.index') }}" class="px-6 py-2.5 bg-white hover:bg-gray-50 text-gray-600 hover:text-gray-800 font-medium rounded-xl border border-gray-200 shadow-sm transition">
            Volver
        </a>
    </div>

</div>

@endsection
