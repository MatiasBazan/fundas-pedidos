@extends('layouts.app')

@section('content')

<div class="mb-6">
    <a href="{{ route('compras.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-[#FF2D6B] transition-colors mb-3">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver a Compras
    </a>
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Compra #{{ $compra->id }}</h1>
            <p class="text-sm text-gray-500 mt-0.5">{{ $compra->fecha->format('d/m/Y') }} · {{ $compra->items->count() }} {{ Str::plural('item', $compra->items->count()) }}</p>
        </div>
        <span class="text-2xl font-bold text-[#FF2D6B] flex-shrink-0">${{ number_format($compra->total_general, 2, ',', '.') }}</span>
    </div>
</div>

@php
    $fondas     = $compra->items->where('categoria', 'funda');
    $accesorios = $compra->items->where('categoria', 'accesorio');
@endphp

<div class="space-y-4">

    {{-- Fundas --}}
    @if($fondas->isNotEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-3">
            <span class="w-1 h-4 bg-[#FF2D6B] rounded-full"></span>
            <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Fundas</h2>
            <span class="text-xs text-gray-400 ml-auto">{{ $fondas->count() }} {{ Str::plural('item', $fondas->count()) }}</span>
        </div>

        {{-- Mobile --}}
        <div class="block md:hidden divide-y divide-gray-50">
            @foreach($fondas as $item)
                <div class="p-4">
                    <div class="flex justify-between items-start mb-1">
                        <p class="font-semibold text-gray-900 text-sm">{{ $item->nombre_disenio }}</p>
                        <span class="text-[#FF2D6B] font-bold text-sm">${{ number_format($item->precio_total, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center gap-2 mb-1">
                        <p class="text-xs text-gray-500">{{ $item->modelo_celular }}</p>
                        <span class="text-xs bg-[#FFF0F5] text-[#FF2D6B] px-1.5 py-0.5 rounded font-medium">Funda</span>
                    </div>
                    <p class="text-xs text-gray-400">{{ number_format($item->cantidad) }} uds. · ${{ number_format($item->precio_unitario, 2, ',', '.') }} c/u</p>
                </div>
            @endforeach
        </div>

        {{-- Desktop --}}
        <table class="hidden md:table w-full text-sm">
            <thead>
                <tr class="border-b border-gray-50">
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Modelo</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Diseño</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Cant.</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">P. Unit.</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">P. Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($fondas as $i => $item)
                    <tr class="hover:bg-[#FFF0F5]/30 transition-colors">
                        <td class="px-5 py-3.5 text-gray-400 text-xs">{{ $i + 1 }}</td>
                        <td class="px-5 py-3.5 text-gray-600">
                            {{ $item->modelo_celular }}
                            <span class="ml-1.5 text-xs bg-[#FFF0F5] text-[#FF2D6B] px-1.5 py-0.5 rounded font-medium">Funda</span>
                        </td>
                        <td class="px-5 py-3.5 font-medium text-gray-900">{{ $item->nombre_disenio }}</td>
                        <td class="px-5 py-3.5 text-right text-gray-600">{{ number_format($item->cantidad) }}</td>
                        <td class="px-5 py-3.5 text-right text-gray-600">${{ number_format($item->precio_unitario, 2, ',', '.') }}</td>
                        <td class="px-5 py-3.5 text-right font-bold text-gray-900">${{ number_format($item->precio_total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border-t border-gray-100 bg-[#FFF0F5]">
                    <td colspan="3" class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Subtotal fundas</td>
                    <td class="px-5 py-3 text-right font-bold text-gray-900">{{ number_format($fondas->sum('cantidad')) }}</td>
                    <td></td>
                    <td class="px-5 py-3 text-right font-bold text-[#FF2D6B]">${{ number_format($fondas->sum('precio_total'), 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endif

    {{-- Accesorios --}}
    @if($accesorios->isNotEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-3">
            <span class="w-1 h-4 bg-blue-400 rounded-full"></span>
            <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Accesorios</h2>
            <span class="text-xs text-gray-400 ml-auto">{{ $accesorios->count() }} {{ Str::plural('item', $accesorios->count()) }}</span>
        </div>

        {{-- Mobile --}}
        <div class="block md:hidden divide-y divide-gray-50">
            @foreach($accesorios as $item)
                <div class="p-4">
                    <div class="flex justify-between items-start mb-1">
                        <p class="font-semibold text-gray-900 text-sm">{{ $item->nombre_disenio }}</p>
                        <span class="text-blue-500 font-bold text-sm">${{ number_format($item->precio_total, 2, ',', '.') }}</span>
                    </div>
                    <div class="mb-1">
                        <span class="text-xs bg-blue-50 text-blue-500 px-1.5 py-0.5 rounded font-medium">Accesorio</span>
                    </div>
                    <p class="text-xs text-gray-400">{{ number_format($item->cantidad) }} uds. · ${{ number_format($item->precio_unitario, 2, ',', '.') }} c/u</p>
                </div>
            @endforeach
        </div>

        {{-- Desktop --}}
        <table class="hidden md:table w-full text-sm">
            <thead>
                <tr class="border-b border-gray-50">
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Nombre</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Cant.</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">P. Unit.</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">P. Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($accesorios as $i => $item)
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td class="px-5 py-3.5 text-gray-400 text-xs">{{ $i + 1 }}</td>
                        <td class="px-5 py-3.5 font-medium text-gray-900">
                            {{ $item->nombre_disenio }}
                            <span class="ml-1.5 text-xs bg-blue-50 text-blue-500 px-1.5 py-0.5 rounded font-medium">Accesorio</span>
                        </td>
                        <td class="px-5 py-3.5 text-right text-gray-600">{{ number_format($item->cantidad) }}</td>
                        <td class="px-5 py-3.5 text-right text-gray-600">${{ number_format($item->precio_unitario, 2, ',', '.') }}</td>
                        <td class="px-5 py-3.5 text-right font-bold text-gray-900">${{ number_format($item->precio_total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border-t border-gray-100 bg-blue-50">
                    <td colspan="2" class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Subtotal accesorios</td>
                    <td class="px-5 py-3 text-right font-bold text-gray-900">{{ number_format($accesorios->sum('cantidad')) }}</td>
                    <td></td>
                    <td class="px-5 py-3 text-right font-bold text-blue-500">${{ number_format($accesorios->sum('precio_total'), 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endif

    {{-- Observaciones --}}
    @if($compra->observaciones)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2 mb-3">
            <span class="w-1 h-4 bg-[#FF2D6B] rounded-full"></span>
            Observaciones
        </h2>
        <p class="text-gray-700 text-sm">{{ $compra->observaciones }}</p>
    </div>
    @endif

    {{-- Actions --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('compras.edit', $compra) }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#FF2D6B] hover:bg-[#E0245E] text-white rounded-xl text-sm font-semibold transition-all shadow-sm shadow-[#FF2D6B]/30">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Editar
        </a>
        <form method="POST" action="{{ route('compras.destroy', $compra) }}" onsubmit="return confirm('¿Eliminar esta compra y todos sus items?')">
            @csrf @method('DELETE')
            <button class="inline-flex items-center gap-2 px-6 py-2.5 bg-white hover:bg-red-50 text-red-500 hover:text-red-600 font-medium rounded-xl border border-red-200 shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Eliminar
            </button>
        </form>
        <a href="{{ route('compras.index') }}" class="px-6 py-2.5 bg-white hover:bg-gray-50 text-gray-600 hover:text-gray-800 font-medium rounded-xl border border-gray-200 shadow-sm transition">
            Volver
        </a>
    </div>

</div>

@endsection
