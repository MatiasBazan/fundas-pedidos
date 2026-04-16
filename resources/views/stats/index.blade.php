@extends('layouts.app')

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
@endpush

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Estadísticas</h1>
    <p class="text-sm text-gray-500 mt-0.5">Resumen del mes actual · {{ now()->translatedFormat('F Y') }}</p>
</div>

{{-- KPI Cards - fila 1 --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-4">

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-[#FF2D6B]/5 rounded-full -translate-y-4 translate-x-4"></div>
        <div class="w-9 h-9 bg-[#FFD6E5] rounded-xl flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-[#FF2D6B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
        </div>
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Vendido este mes</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">${{ number_format($totalVendido, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-400 mt-1">suma de pedidos</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-blue-500/5 rounded-full -translate-y-4 translate-x-4"></div>
        <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
            </svg>
        </div>
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Comprado este mes</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">${{ number_format($totalComprado, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-400 mt-1">suma de compras</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 relative overflow-hidden col-span-2">
        <div class="absolute top-0 right-0 w-20 h-20 {{ $ganancia >= 0 ? 'bg-emerald-500/5' : 'bg-rose-500/5' }} rounded-full -translate-y-4 translate-x-4"></div>
        <div class="w-9 h-9 {{ $ganancia >= 0 ? 'bg-emerald-100' : 'bg-rose-100' }} rounded-xl flex items-center justify-center mb-3">
            <svg class="w-5 h-5 {{ $ganancia >= 0 ? 'text-emerald-500' : 'text-rose-500' }}" fill="currentColor" viewBox="0 0 20 20">
                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
            </svg>
        </div>
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Ganancia estimada</p>
        <p class="text-3xl font-bold {{ $ganancia >= 0 ? 'text-emerald-600' : 'text-rose-600' }} mt-1">${{ number_format($ganancia, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-400 mt-1">vendido − comprado del mes</p>
    </div>

</div>

{{-- KPI Cards - fila 2 --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-sky-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-sky-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Disponibles</p>
                <p class="text-xl font-bold text-gray-900">{{ $pedidosDisponibles }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Entregados</p>
                <p class="text-xl font-bold text-gray-900">{{ $pedidosEntregados }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-[#FFD6E5] rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-[#FF2D6B]" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Pagados</p>
                <p class="text-xl font-bold text-gray-900">{{ $pedidosPagados }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-rose-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-rose-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">No pagados</p>
                <p class="text-xl font-bold text-gray-900">{{ $pedidosNoPagados }}</p>
            </div>
        </div>
    </div>

</div>

{{-- Gráficos --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center gap-2 mb-1">
            <span class="w-2.5 h-2.5 bg-[#FF2D6B] rounded-full"></span>
            <h2 class="text-sm font-bold text-gray-800">Ventas por mes</h2>
        </div>
        <p class="text-xs text-gray-400 mb-5 ml-4">Últimos 6 meses</p>
        <canvas id="chartVentas" height="200"></canvas>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center gap-2 mb-1">
            <span class="w-2.5 h-2.5 bg-blue-400 rounded-full"></span>
            <h2 class="text-sm font-bold text-gray-800">Compras por mes</h2>
        </div>
        <p class="text-xs text-gray-400 mb-5 ml-4">Últimos 6 meses</p>
        <canvas id="chartCompras" height="200"></canvas>
    </div>

</div>

<script>
    const ventasData  = @json($ventasPorMes);
    const comprasData = @json($comprasPorMes);

    const baseOptions = {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ' $' + ctx.raw.toLocaleString('es-AR', { minimumFractionDigits: 2 })
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: '#f3f4f6', drawBorder: false },
                ticks: {
                    color: '#9ca3af',
                    font: { size: 11 },
                    callback: v => '$' + v.toLocaleString('es-AR')
                }
            },
            x: {
                grid: { display: false },
                ticks: { color: '#9ca3af', font: { size: 11 } }
            }
        }
    };

    new Chart(document.getElementById('chartVentas'), {
        type: 'bar',
        data: {
            labels: ventasData.map(d => d.mes),
            datasets: [{
                data: ventasData.map(d => d.total),
                backgroundColor: 'rgba(249,115,22,0.15)',
                borderColor: 'rgb(249,115,22)',
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: 'rgba(249,115,22,0.3)',
            }]
        },
        options: baseOptions
    });

    new Chart(document.getElementById('chartCompras'), {
        type: 'bar',
        data: {
            labels: comprasData.map(d => d.mes),
            datasets: [{
                data: comprasData.map(d => d.total),
                backgroundColor: 'rgba(96,165,250,0.15)',
                borderColor: 'rgb(96,165,250)',
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: 'rgba(96,165,250,0.3)',
            }]
        },
        options: baseOptions
    });
</script>

@endsection
