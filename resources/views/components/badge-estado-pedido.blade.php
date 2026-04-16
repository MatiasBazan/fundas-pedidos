@props(['estado', 'size' => 'xs'])

@if($estado === 'disponible')
    <span class="inline-flex items-center gap-1.5 bg-sky-50 text-sky-700 border border-sky-200 px-2.5 py-1 rounded-full text-{{ $size }} font-semibold">
        <span class="w-1.5 h-1.5 bg-sky-500 rounded-full"></span>
        Disponible
    </span>
@else
    <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full text-{{ $size }} font-semibold">
        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
        Entregado
    </span>
@endif
