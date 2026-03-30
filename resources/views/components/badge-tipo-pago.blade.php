@props(['tipo', 'size' => 'xs'])

@if($tipo === 'efectivo')
    <span class="inline-flex items-center bg-yellow-100 text-yellow-700 px-3 py-1.5 rounded-full text-{{ $size }} font-semibold">
        <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
        Efectivo
    </span>
@elseif($tipo === 'transferencia')
    <span class="inline-flex items-center bg-purple-100 text-purple-700 px-3 py-1.5 rounded-full text-{{ $size }} font-semibold">
        <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
        Transferencia
    </span>
@else
    <span class="text-gray-300 text-{{ $size }} font-medium">—</span>
@endif
