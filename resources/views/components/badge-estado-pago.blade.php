@props(['estado', 'size' => 'xs'])

@if($estado === 'pagado')
    <span class="inline-flex items-center bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-{{ $size }} font-semibold">
        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
        Pagado
    </span>
@else
    <span class="inline-flex items-center bg-red-100 text-red-700 px-3 py-1.5 rounded-full text-{{ $size }} font-semibold">
        <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
        No pagado
    </span>
@endif
