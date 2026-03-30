@extends('layouts.app')

@section('content')

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Estadísticas de Pedidos</h1>
        <p class="text-gray-600 mt-1">Resumen general de tu negocio</p>
    </div>

    <!-- Tarjetas de resumen mejoradas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Pedidos -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-sm opacity-90 font-medium">Total Pedidos</p>
                    <h3 class="text-4xl font-bold mt-2">{{ $totalPedidos }}</h3>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
            <div class="flex items-center text-sm opacity-90">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                </svg>
                <span>Todos los registros</span>
            </div>
        </div>

        <!-- Ingresos Totales -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-sm opacity-90 font-medium">Ingresos Totales</p>
                    <h3 class="text-4xl font-bold mt-2">${{ number_format($totalIngresos, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
            <div class="flex items-center text-sm opacity-90">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                </svg>
                <span>Pedidos pagados</span>
            </div>
        </div>

        <!-- Pendientes de Pago -->
        <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-sm opacity-90 font-medium">Pendientes Pago</p>
                    <h3 class="text-4xl font-bold mt-2">{{ $pedidosPendientesPago }}</h3>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
            <div class="flex items-center text-sm opacity-90">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                </svg>
                <span>Por cobrar</span>
            </div>
        </div>

        <!-- Monto Pendiente -->
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-sm opacity-90 font-medium">Monto Pendiente</p>
                    <h3 class="text-4xl font-bold mt-2">${{ number_format($montoPendiente, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
            <div class="flex items-center text-sm opacity-90">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                </svg>
                <span>Total adeudado</span>
            </div>
        </div>
    </div>

    <!-- Tablas de datos mejoradas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Estados de Pedido -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    Por Estado de Pedido
                </h3>
            </div>
            <div class="p-6">
                <table class="w-full text-sm">
                    <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Cantidad</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($estadosPedido as $estado)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4">
                                <x-badge-estado-pedido :estado="$estado->estado_pedido" />
                            </td>
                            <td class="px-4 py-4 font-semibold text-gray-900">{{ $estado->cantidad }}</td>
                            <td class="px-4 py-4 font-semibold text-gray-900">${{ number_format($estado->total, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Estados de Pago -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                    Por Estado de Pago
                </h3>
            </div>
            <div class="p-6">
                <table class="w-full text-sm">
                    <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Cantidad</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($estadosPago as $estado)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4">
                                <x-badge-estado-pago :estado="$estado->estado_pago" />
                            </td>
                            <td class="px-4 py-4 font-semibold text-gray-900">{{ $estado->cantidad }}</td>
                            <td class="px-4 py-4 font-semibold text-gray-900">${{ number_format($estado->total, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tipos de pago y Marcas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Tipos de Pago -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                    Por Tipo de Pago
                </h3>
            </div>
            <div class="p-6">
                <table class="w-full text-sm">
                    <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipo</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Cantidad</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($tiposPago as $tipo)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4">
                                <x-badge-tipo-pago :tipo="$tipo->tipo_pago" />
                            </td>
                            <td class="px-4 py-4 font-semibold text-gray-900">{{ $tipo->cantidad }}</td>
                            <td class="px-4 py-4 font-semibold text-gray-900">${{ number_format($tipo->total, 2, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-gray-400">No hay datos disponibles</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Marcas Top -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                    Top 5 Marcas
                </h3>
            </div>
            <div class="p-6">
                <table class="w-full text-sm">
                    <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Marca</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Cantidad</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($marcasTop as $index => $marca)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-orange-100 text-orange-600 text-xs font-bold">
                                        {{ $index + 1 }}
                                    </span>
                                    <span class="font-semibold text-gray-900">{{ $marca->marca }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 font-semibold text-gray-900">{{ $marca->cantidad }}</td>
                            <td class="px-4 py-4 font-semibold text-gray-900">${{ number_format($marca->total, 2, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-gray-400">No hay datos disponibles</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modelos Top -->
    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200 mb-6">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <span class="w-2 h-2 bg-indigo-500 rounded-full"></span>
                Top 5 Modelos Más Vendidos
            </h3>
        </div>
        <div class="p-6">
            <table class="w-full text-sm">
                <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Modelo</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Marca</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Cantidad</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                </tr>
                </thead>
                <tbody>
                @forelse($modelosTop as $index => $modelo)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold">
                                    {{ $index + 1 }}
                                </span>
                                <span class="font-semibold text-gray-900">{{ $modelo->modelo }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-gray-700">{{ $modelo->marca }}</td>
                        <td class="px-4 py-4 font-semibold text-gray-900">{{ $modelo->cantidad }}</td>
                        <td class="px-4 py-4 font-semibold text-gray-900">${{ number_format($modelo->total, 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-400">No hay datos disponibles</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Gráfico -->
    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                Pedidos por Mes (Últimos 6 meses)
            </h3>
        </div>
        <div class="p-6">
            <canvas id="chartVentasMensuales" style="max-height: 400px;"></canvas>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('chartVentasMensuales');

                const meses = @json($pedidosPorMes->pluck('mes'));
                const cantidades = @json($pedidosPorMes->pluck('cantidad'));
                const totales = @json($pedidosPorMes->pluck('total'));

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'Cantidad de Pedidos',
                            data: cantidades,
                            backgroundColor: 'rgba(59, 130, 246, 0.6)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 2,
                            borderRadius: 8,
                            yAxisID: 'y'
                        }, {
                            label: 'Ingresos ($)',
                            data: totales,
                            backgroundColor: 'rgba(249, 115, 22, 0.6)',
                            borderColor: 'rgba(249, 115, 22, 1)',
                            borderWidth: 2,
                            borderRadius: 8,
                            yAxisID: 'y1'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    font: {
                                        size: 12,
                                        weight: 'bold'
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Cantidad de Pedidos',
                                    font: {
                                        weight: 'bold'
                                    }
                                },
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Ingresos ($)',
                                    font: {
                                        weight: 'bold'
                                    }
                                },
                                beginAtZero: true,
                                grid: {
                                    drawOnChartArea: false
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush

@endsection
