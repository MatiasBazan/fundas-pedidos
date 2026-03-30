@props(['estado', 'size' => 'xs'])

@if($estado === 'disponible')
    <span class="inline-flex items-center bg-blue-100 text-blue-700 px-3 py-1.5 rounded-full text-{{ $size }} font-semibold">
        <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
        Disponible
    </span>
@else
    <span class="inline-flex items-center bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-{{ $size }} font-semibold">
        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
        Entregado
    </span>
@endif
