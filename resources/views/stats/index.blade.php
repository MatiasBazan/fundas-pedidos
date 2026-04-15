@extends('layouts.app')

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
@endpush

@section('content')

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Estadísticas</h1>
        <p class="text-gray-600 mt-1">Resumen del mes actual y evolución de los últimos 6 meses</p>
    </div>

    {{-- Cards de resumen --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        {{-- Total vendido --}}
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Vendido este mes</p>
            <p class="text-2xl font-bold text-gray-800">${{ number_format($totalVendido, 2, ',', '.') }}</p>
            <div class="mt-2 flex items-center gap-1">
                <div class="bg-orange-100 p-1 rounded">
                    <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"></path>
                    </svg>
                </div>
                <span class="text-xs text-gray-400">Suma de pedidos del mes</span>
            </div>
        </div>

        {{-- Total comprado --}}
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-400">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Comprado este mes</p>
            <p class="text-2xl font-bold text-gray-800">${{ number_format($totalComprado, 2, ',', '.') }}</p>
            <div class="mt-2 flex items-center gap-1">
                <div class="bg-blue-100 p-1 rounded">
                    <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <span class="text-xs text-gray-400">Suma de compras del mes</span>
            </div>
        </div>

        {{-- Ganancia --}}
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 {{ $ganancia >= 0 ? 'border-green-500' : 'border-red-500' }}">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Ganancia estimada</p>
            <p class="text-2xl font-bold {{ $ganancia >= 0 ? 'text-green-600' : 'text-red-600' }}">
                ${{ number_format($ganancia, 2, ',', '.') }}
            </p>
            <div class="mt-2 flex items-center gap-1">
                <div class="{{ $ganancia >= 0 ? 'bg-green-100' : 'bg-red-100' }} p-1 rounded">
                    <svg class="w-4 h-4 {{ $ganancia >= 0 ? 'text-green-500' : 'text-red-500' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <span class="text-xs text-gray-400">Vendido − Comprado</span>
            </div>
        </div>

        {{-- Pedidos disponibles --}}
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-400">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Pedidos disponibles</p>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($pedidosDisponibles) }}</p>
            <div class="mt-2 flex items-center gap-1">
                <div class="bg-yellow-100 p-1 rounded">
                    <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <span class="text-xs text-gray-400">Sin entregar aún</span>
            </div>
        </div>

    </div>

    {{-- Segunda fila de cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">

        <div class="bg-white rounded-xl shadow-md p-6 flex items-center gap-4">
            <div class="bg-green-100 p-3 rounded-xl">
                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Entregados</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($pedidosEntregados) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 flex items-center gap-4">
            <div class="bg-orange-100 p-3 rounded-xl">
                <svg class="w-6 h-6 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pagados</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($pedidosPagados) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 flex items-center gap-4">
            <div class="bg-red-100 p-3 rounded-xl">
                <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">No pagados</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($pedidosNoPagados) }}</p>
            </div>
        </div>

    </div>

    {{-- Gráficos --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Gráfico ventas --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-1">Ventas por mes</h2>
            <p class="text-xs text-gray-400 mb-4">Últimos 6 meses</p>
            <canvas id="chartVentas" height="220"></canvas>
        </div>

        {{-- Gráfico compras --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-1">Compras por mes</h2>
            <p class="text-xs text-gray-400 mb-4">Últimos 6 meses</p>
            <canvas id="chartCompras" height="220"></canvas>
        </div>

    </div>

    <script>
        const ventasData  = @json($ventasPorMes);
        const comprasData = @json($comprasPorMes);

        const chartDefaults = {
            type: 'bar',
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: v => '$' + v.toLocaleString('es-AR')
                        },
                        grid: { color: '#f3f4f6' }
                    },
                    x: { grid: { display: false } }
                }
            }
        };

        new Chart(document.getElementById('chartVentas'), {
            ...chartDefaults,
            data: {
                labels: ventasData.map(d => d.mes),
                datasets: [{
                    data: ventasData.map(d => d.total),
                    backgroundColor: 'rgba(249, 115, 22, 0.8)',
                    borderColor: 'rgb(234, 88, 12)',
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            }
        });

        new Chart(document.getElementById('chartCompras'), {
            ...chartDefaults,
            data: {
                labels: comprasData.map(d => d.mes),
                datasets: [{
                    data: comprasData.map(d => d.total),
                    backgroundColor: 'rgba(96, 165, 250, 0.8)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            }
        });
    </script>

@endsection
