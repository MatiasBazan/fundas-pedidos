@props(['estado', 'size' => 'xs'])

@if($estado === 'pagado')
    <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full text-{{ $size }} font-semibold">
        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
        Pagado
    </span>
@else
    <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-1 rounded-full text-{{ $size }} font-semibold">
        <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>
        No pagado
    </span>
@endif
