@extends('layouts.app')

@section('content')

<div class="flex flex-wrap items-start sm:items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Stock</h1>
        <p class="text-sm text-gray-500 mt-0.5">Unidades disponibles por producto</p>
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
<div x-data="{ cat: '{{ request('categoria', '') }}' }" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-5">
    <form method="GET" action="{{ route('stock.index') }}">
        <input type="hidden" name="categoria" :value="cat">

        <div class="flex items-center gap-3 flex-wrap">
            {{-- Modelo --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs font-medium text-gray-400 uppercase tracking-wide">Modelo</label>
                <div class="w-44">
                    <select name="modelo_celular"
                            :disabled="cat === 'accesorio'"
                            x-init="$el._ts = new TomSelect($el, { create: false, allowEmptyOption: true, maxOptions: 300 })"
                            x-effect="if ($el._ts) { cat === 'accesorio' ? $el._ts.disable() : $el._ts.enable() }">
                        <option value="">Todos los modelos</option>
                        @foreach($modelos as $modelo)
                            <option value="{{ $modelo }}" {{ request('modelo_celular') === $modelo ? 'selected' : '' }}>{{ $modelo }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Diseño / Nombre --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs font-medium text-gray-400 uppercase tracking-wide">Diseño / Nombre</label>
                <div class="w-44">
                    <div x-show="cat !== 'accesorio'" style="display:none">
                        <select name="nombre_disenio"
                                :disabled="cat === 'accesorio'"
                                x-init="$el._ts = new TomSelect($el, { create: false, allowEmptyOption: true, maxOptions: 300 })"
                                x-effect="if ($el._ts) { cat === 'accesorio' ? $el._ts.disable() : $el._ts.enable() }">
                            <option value="">Todos los diseños</option>
                            @foreach($disenios as $d)
                                <option value="{{ $d }}" {{ request('nombre_disenio') === $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div x-show="cat === 'accesorio'" style="display:none">
                        <select name="nombre_disenio"
                                :disabled="cat !== 'accesorio'"
                                x-init="$el._ts = new TomSelect($el, { create: false, allowEmptyOption: true, maxOptions: 300 })"
                                x-effect="if ($el._ts) { cat !== 'accesorio' ? $el._ts.disable() : $el._ts.enable() }">
                            <option value="">Todos los nombres</option>
                            @foreach($nombresAccesorio as $n)
                                <option value="{{ $n }}" {{ request('nombre_disenio') === $n ? 'selected' : '' }}>{{ $n }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Categoría pills --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs font-medium text-gray-400 uppercase tracking-wide">Categoría</label>
                <div class="flex items-center gap-1.5">
                    <button type="button" @click="cat = ''"
                            :class="cat === '' ? 'bg-[#FF2D6B] text-white border-[#FF2D6B] font-medium' : 'bg-white text-gray-500 border border-gray-200 hover:border-[#FF2D6B] hover:text-[#FF2D6B]'"
                            class="rounded-full px-4 py-2 text-sm transition cursor-pointer border">
                        Todos
                    </button>
                    <button type="button" @click="cat = 'funda'"
                            :class="cat === 'funda' ? 'bg-[#FF2D6B] text-white border-[#FF2D6B] font-medium' : 'bg-white text-gray-500 border border-gray-200 hover:border-[#FF2D6B] hover:text-[#FF2D6B]'"
                            class="rounded-full px-4 py-2 text-sm transition cursor-pointer border">
                        📱 Fundas
                    </button>
                    <button type="button" @click="cat = 'accesorio'"
                            :class="cat === 'accesorio' ? 'bg-[#FF2D6B] text-white border-[#FF2D6B] font-medium' : 'bg-white text-gray-500 border border-gray-200 hover:border-[#FF2D6B] hover:text-[#FF2D6B]'"
                            class="rounded-full px-4 py-2 text-sm transition cursor-pointer border">
                        🛍 Accesorios
                    </button>
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex items-center gap-2 self-center mt-4">
                <button type="submit" class="bg-[#FF2D6B] hover:bg-[#E0245E] text-white px-6 py-2 rounded-xl text-sm font-semibold transition-all">Filtrar</button>
                <a href="{{ route('stock.index') }}" class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-600 hover:text-gray-800 font-medium rounded-xl border border-gray-200 shadow-sm transition">✕</a>
            </div>
        </div>
    </form>
</div>

@php
    $stockBadge = function(int $cantidad) {
        if ($cantidad > 3)  return ['bg-emerald-50 text-emerald-700 border-emerald-200', 'bg-emerald-500', $cantidad . ' uds.'];
        if ($cantidad >= 1) return ['bg-amber-50 text-amber-700 border-amber-200',   'bg-amber-500',   $cantidad . ' uds.'];
        return              ['bg-rose-50 text-rose-700 border-rose-200',             'bg-rose-500',    'Sin stock'];
    };
@endphp

{{-- ── FUNDAS ──────────────────────────────────────────────────────────── --}}
@if(!request('categoria') || request('categoria') === 'funda')
<div class="mb-6">
    <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2 mb-3">
        <span class="w-1 h-4 bg-[#FF2D6B] rounded-full"></span>
        Fundas
    </h2>

    {{-- Mobile --}}
    <div class="block md:hidden space-y-3">
        @forelse($fondas as $stock)
            @php [$cls, $dot, $label] = $stockBadge($stock->cantidad) @endphp
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-4 py-3.5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-gray-900 text-sm">{{ $stock->nombre_disenio }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $stock->modelo_celular }}</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 border px-3 py-1.5 rounded-full text-sm font-bold {{ $cls }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span> {{ $label }}
                    </span>
                </div>
                <div class="flex justify-end pt-2 mt-2 border-t border-gray-100">
                    <form method="POST" action="{{ route('stock.destroy', $stock) }}">
                        @csrf @method('DELETE')
                        <button type="button" onclick="showDeleteModal(this.closest('form'), '{{ $stock->nombre_disenio }} ({{ $stock->modelo_celular }})')"
                                class="py-1.5 px-3 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">Eliminar</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center text-gray-400 text-sm">Sin fundas en stock</div>
        @endforelse
        @if($fondas->hasPages()) <div class="pt-2">{{ $fondas->links() }}</div> @endif
    </div>

    {{-- Desktop --}}
    <div class="hidden md:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Modelo</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Diseño</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Cantidad</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Actualizado</th>
                    <th class="px-5 py-3.5 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
            @forelse($fondas as $stock)
                @php [$cls, $dot, $label] = $stockBadge($stock->cantidad) @endphp
                <tr class="hover:bg-[#FFF0F5]/40 transition-colors">
                    <td class="px-5 py-4 text-gray-400 text-xs font-mono">{{ $stock->id }}</td>
                    <td class="px-5 py-4 text-gray-500">{{ $stock->modelo_celular }}</td>
                    <td class="px-5 py-4 font-semibold text-gray-900">{{ $stock->nombre_disenio }}</td>
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center gap-1.5 border px-2.5 py-1 rounded-full text-xs font-bold {{ $cls }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span> {{ $label }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-gray-400 text-xs">{{ $stock->updated_at->format('d/m/Y H:i') }}</td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-end">
                            <form method="POST" action="{{ route('stock.destroy', $stock) }}">
                                @csrf @method('DELETE')
                                <button type="button" onclick="showDeleteModal(this.closest('form'), '{{ $stock->nombre_disenio }} ({{ $stock->modelo_celular }})')"
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-gray-400 text-sm">Sin fundas en stock</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        @if($fondas->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">{{ $fondas->links() }}</div>
        @endif
    </div>
</div>

@endif
{{-- ── ACCESORIOS ──────────────────────────────────────────────────────── --}}
@if(!request('categoria') || request('categoria') === 'accesorio')
<div>
    <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2 mb-3">
        <span class="w-1 h-4 bg-blue-400 rounded-full"></span>
        Accesorios
    </h2>

    {{-- Mobile --}}
    <div class="block md:hidden space-y-3">
        @forelse($accesorios as $stock)
            @php [$cls, $dot, $label] = $stockBadge($stock->cantidad) @endphp
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-4 py-3.5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-gray-900 text-sm">{{ $stock->nombre_disenio }}</p>
                        <span class="text-xs bg-blue-50 text-blue-500 px-1.5 py-0.5 rounded font-medium">Accesorio</span>
                    </div>
                    <span class="inline-flex items-center gap-1.5 border px-3 py-1.5 rounded-full text-sm font-bold {{ $cls }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span> {{ $label }}
                    </span>
                </div>
                <div class="flex justify-end pt-2 mt-2 border-t border-gray-100">
                    <form method="POST" action="{{ route('stock.destroy', $stock) }}">
                        @csrf @method('DELETE')
                        <button type="button" onclick="showDeleteModal(this.closest('form'), '{{ $stock->nombre_disenio }}')"
                                class="py-1.5 px-3 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">Eliminar</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center text-gray-400 text-sm">Sin accesorios en stock</div>
        @endforelse
        @if($accesorios->hasPages()) <div class="pt-2">{{ $accesorios->links() }}</div> @endif
    </div>

    {{-- Desktop --}}
    <div class="hidden md:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Nombre del accesorio</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Cantidad</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Actualizado</th>
                    <th class="px-5 py-3.5 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
            @forelse($accesorios as $stock)
                @php [$cls, $dot, $label] = $stockBadge($stock->cantidad) @endphp
                <tr class="hover:bg-blue-50/30 transition-colors">
                    <td class="px-5 py-4 text-gray-400 text-xs font-mono">{{ $stock->id }}</td>
                    <td class="px-5 py-4 font-semibold text-gray-900">{{ $stock->nombre_disenio }}</td>
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center gap-1.5 border px-2.5 py-1 rounded-full text-xs font-bold {{ $cls }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span> {{ $label }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-gray-400 text-xs">{{ $stock->updated_at->format('d/m/Y H:i') }}</td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-end">
                            <form method="POST" action="{{ route('stock.destroy', $stock) }}">
                                @csrf @method('DELETE')
                                <button type="button" onclick="showDeleteModal(this.closest('form'), '{{ $stock->nombre_disenio }}')"
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-12 text-center text-gray-400 text-sm">Sin accesorios en stock</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        @if($accesorios->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">{{ $accesorios->links() }}</div>
        @endif
    </div>
</div>
@endif

@endsection
