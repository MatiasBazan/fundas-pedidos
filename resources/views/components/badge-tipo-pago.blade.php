@props(['tipo', 'size' => 'xs'])

@if($tipo === 'efectivo')
    <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-full text-{{ $size }} font-semibold">
        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
        Efectivo
    </span>
@elseif($tipo === 'transferencia')
    <span class="inline-flex items-center gap-1.5 bg-violet-50 text-violet-700 border border-violet-200 px-2.5 py-1 rounded-full text-{{ $size }} font-semibold">
        <span class="w-1.5 h-1.5 bg-violet-500 rounded-full"></span>
        Transferencia
    </span>
@else
    <span class="text-gray-300 text-{{ $size }}">—</span>
@endif
