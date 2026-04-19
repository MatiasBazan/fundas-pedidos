@extends('layouts.app')

@section('content')

<div class="mb-6">
    <a href="{{ route('compras.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-[#FF2D6B] transition-colors mb-3">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver a Compras
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Nueva compra</h1>
    <p class="text-sm text-gray-500 mt-0.5">Registrá una compra al mayorista con uno o más items</p>
</div>

<div x-data="compraForm">

<form method="POST" action="{{ route('compras.store') }}" class="space-y-5"
      @submit="console.log('compra submit - items:', JSON.parse(JSON.stringify(items)))">
    @csrf

    {{-- Datos generales --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2 mb-4">
            <span class="w-1 h-4 bg-[#FF2D6B] rounded-full"></span>
            Datos generales
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1.5">Fecha <span class="text-red-400">*</span></label>
                <input type="date" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all @error('fecha') border-red-300 bg-red-50 @enderror">
                @error('fecha') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1.5">Observaciones</label>
                <input type="text" name="observaciones" value="{{ old('observaciones') }}" placeholder="Notas adicionales..."
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all">
            </div>
        </div>
    </div>

    {{-- Items --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
        <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
            <span class="w-1 h-4 bg-[#FF2D6B] rounded-full"></span>
            Items
        </h2>

        @error('items') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror

        <template x-for="(item, index) in items" :key="index">
            <div class="border border-gray-100 rounded-xl p-4 space-y-3 bg-gray-50/40">

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide" x-text="'Item ' + (index + 1)"></span>
                        <div class="flex items-center gap-1.5">
                            <button type="button"
                                    @click="onCategoriaChange(item, 'funda')"
                                    :class="item.categoria === 'funda'
                                        ? 'bg-[#FF2D6B] text-white border-[#FF2D6B] font-medium'
                                        : 'bg-white text-gray-500 border border-gray-200 hover:border-[#FF2D6B] hover:text-[#FF2D6B]'"
                                    class="rounded-full px-4 py-1.5 text-sm transition cursor-pointer border">
                                📱 Funda
                            </button>
                            <button type="button"
                                    @click="onCategoriaChange(item, 'accesorio')"
                                    :class="item.categoria === 'accesorio'
                                        ? 'bg-[#FF2D6B] text-white border-[#FF2D6B] font-medium'
                                        : 'bg-white text-gray-500 border border-gray-200 hover:border-[#FF2D6B] hover:text-[#FF2D6B]'"
                                    class="rounded-full px-4 py-1.5 text-sm transition cursor-pointer border">
                                🛍 Accesorio
                            </button>
                        </div>
                    </div>
                    <button type="button" @click="removeItem(index)" x-show="items.length > 1"
                            class="text-xs text-red-400 hover:text-red-600 hover:bg-red-50 px-2 py-1 rounded-lg transition-colors flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Quitar
                    </button>
                </div>

                <input type="hidden" :name="'items[' + index + '][categoria]'" :value="item.categoria">

                {{-- Marca / Modelo (solo funda) --}}
                <div x-show="item.categoria === 'funda'" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Marca <span class="text-red-400">*</span></label>
                        <select @change="onMarcaChange(item, $event.target.value)"
                                x-effect="
                                    if (!$el._ts) $el._ts = new TomSelect($el, { create: false, allowEmptyOption: true, maxOptions: 300 });
                                    $el._ts.setValue(item.showNuevaMarca ? 'nueva' : (String(item.marcaId) || ''), true);
                                ">
                            <option value="">Seleccioná una marca</option>
                            @foreach($marcas as $marca)
                                <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                            @endforeach
                            <option value="nueva">＋ Nueva marca</option>
                        </select>
                        <div x-show="item.showNuevaMarca" x-transition class="mt-1.5">
                            <input type="text" :name="'items[' + index + '][marca_nueva]'" x-model="item.marcaNueva"
                                   placeholder="Nombre de la marca"
                                   class="w-full border border-[#FF8FAB] rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] bg-[#FFF0F5]/30 transition-all">
                        </div>
                        <input type="hidden" :name="'items[' + index + '][marca_id]'" :value="item.showNuevaMarca ? '' : item.marcaId">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Modelo <span class="text-red-400">*</span></label>
                        <select @change="onModeloChange(item, $event.target.value)"
                                x-effect="
                                    if (!$el._ts) $el._ts = new TomSelect($el, { create: false, allowEmptyOption: true, maxOptions: 300 });
                                    let ts = $el._ts, ms = modelosFiltrados(item), hasCtx = !!(item.marcaId || item.showNuevaMarca);
                                    ts.clearOptions();
                                    ts.addOption({ value: '', text: hasCtx ? 'Seleccioná un modelo' : 'Primero seleccioná marca' });
                                    ms.forEach(m => ts.addOption({ value: String(m.id), text: m.nombre }));
                                    if (hasCtx) ts.addOption({ value: 'nuevo', text: '＋ Nuevo modelo' });
                                    ts.refreshOptions(false);
                                    ts.setValue(item.showNuevoModelo ? 'nuevo' : (item.modeloId ? String(item.modeloId) : ''), true);
                                    (ms.length === 0 && !item.showNuevaMarca) ? ts.disable() : ts.enable();
                                ">
                            <option value="">Primero seleccioná marca</option>
                        </select>
                        <div x-show="item.showNuevoModelo" x-transition class="mt-1.5">
                            <input type="text" :name="'items[' + index + '][modelo_nuevo]'" x-model="item.modeloNuevo"
                                   placeholder="Nombre del modelo"
                                   class="w-full border border-[#FF8FAB] rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] bg-[#FFF0F5]/30 transition-all">
                        </div>
                        <input type="hidden" :name="'items[' + index + '][modelo_id]'" :value="item.showNuevoModelo ? '' : item.modeloId">
                    </div>
                </div>

                {{-- Diseño (funda) / Descripción (accesorio) --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">
                        <span x-text="item.categoria === 'accesorio' ? 'Descripción' : 'Diseño'"></span>
                        <span class="text-red-400">*</span>
                    </label>
                    <input type="text" :name="'items[' + index + '][nombre_disenio]'" x-model="item.nombreDisenio"
                           :placeholder="item.categoria === 'accesorio' ? 'Ej: Cable USB-C, Auriculares' : 'Ej: Flores rosas'"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all">
                </div>

                {{-- Cantidad / Precio / Subtotal --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Cantidad <span class="text-red-400">*</span></label>
                        <input type="number" :name="'items[' + index + '][cantidad]'" x-model="item.cantidad"
                               min="1" placeholder="0"
                               class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Precio unitario <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">$</span>
                            <input type="number" :name="'items[' + index + '][precio_unitario]'" x-model="item.precioUnitario"
                                   min="0" step="0.01" placeholder="0.00"
                                   class="w-full pl-6 pr-3 border border-gray-200 rounded-xl py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Subtotal</label>
                        <div class="w-full bg-[#FFF0F5] border border-[#FFD6E5] rounded-xl px-3 py-2 text-sm font-semibold text-[#FF2D6B]"
                             x-text="'$' + fmt(itemTotal(item))">$0,00</div>
                    </div>
                </div>

            </div>
        </template>

        <button type="button" @click="addItem()"
                class="w-full py-2.5 border-2 border-dashed border-gray-200 hover:border-[#FF2D6B] text-gray-400 hover:text-[#FF2D6B] rounded-xl text-sm font-medium transition-all flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Agregar item
        </button>

        <div class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-xl px-6 py-4">
            <span class="text-sm font-medium text-gray-500">Total general</span>
            <span class="text-xl font-bold text-[#FF2D6B]" x-text="'$' + fmt(totalGeneral)">$0,00</span>
        </div>
    </div>

    <div class="flex items-center gap-3 border-t border-gray-100 mt-4 pt-4">
        <button type="submit"
                class="px-6 py-2.5 bg-[#FF2D6B] hover:bg-[#E0245E] text-white rounded-xl text-sm font-semibold transition-all shadow-sm shadow-[#FF2D6B]/30">
            Registrar compra
        </button>
        <a href="{{ route('compras.index') }}"
           class="px-6 py-2.5 bg-white hover:bg-gray-50 text-gray-600 hover:text-gray-800 font-medium rounded-xl border border-gray-200 shadow-sm transition">
            Cancelar
        </a>
    </div>

</form>
</div>

<script>
    window._modelosPorMarca = @json($modelosPorMarca);

    document.addEventListener('alpine:init', () => {
        Alpine.data('compraForm', () => ({
            todosModelos: window._modelosPorMarca,
            items: [{
                categoria: 'funda',
                marcaId: '', showNuevaMarca: false, marcaNueva: '',
                modeloId: '', showNuevoModelo: false, modeloNuevo: '',
                nombreDisenio: '', cantidad: '', precioUnitario: ''
            }],

            addItem() {
                this.items.push({
                    categoria: 'funda',
                    marcaId: '', showNuevaMarca: false, marcaNueva: '',
                    modeloId: '', showNuevoModelo: false, modeloNuevo: '',
                    nombreDisenio: '', cantidad: '', precioUnitario: ''
                });
            },

            removeItem(index) {
                if (this.items.length > 1) this.items.splice(index, 1);
            },

            modelosFiltrados(item) {
                if (!item.marcaId || item.showNuevaMarca) return [];
                return this.todosModelos[item.marcaId] || [];
            },

            itemTotal(item) {
                return (parseFloat(item.cantidad) || 0) * (parseFloat(item.precioUnitario) || 0);
            },

            get totalGeneral() {
                return this.items.reduce((sum, item) => sum + this.itemTotal(item), 0);
            },

            onCategoriaChange(item, tipo) {
                item.categoria = tipo;
                item.marcaId = '';
                item.showNuevaMarca = false;
                item.marcaNueva = '';
                item.modeloId = '';
                item.showNuevoModelo = false;
                item.modeloNuevo = '';
                item.nombreDisenio = '';
            },

            onMarcaChange(item, val) {
                item.showNuevaMarca = (val === 'nueva');
                item.marcaId = (val !== 'nueva') ? val : '';
                item.modeloId = '';
                item.showNuevoModelo = false;
                item.modeloNuevo = '';
            },

            onModeloChange(item, val) {
                item.showNuevoModelo = (val === 'nuevo');
                item.modeloId = (val !== 'nuevo') ? val : '';
            },

            fmt(n) {
                return n.toLocaleString('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }
        }));
    });
</script>

@endsection
