@extends('layouts.app')

@section('content')

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pedidos.index') }}"
           class="text-gray-400 hover:text-orange-500 transition">← Volver</a>
        <h1 class="text-2xl font-semibold text-gray-800">Pedido #{{ $pedido->id }}</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl mx-auto">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            <div>
                <p class="text-xs text-gray-400 uppercase font-medium mb-1">Nombre del diseño</p>
                <p class="text-gray-800 font-medium">{{ $pedido->nombre_disenio }}</p>
            </div>

            <div>
                <p class="text-xs text-gray-400 uppercase font-medium mb-1">Modelo de celular</p>
                <p class="text-gray-800">{{ $pedido->modelo_celular }}</p>
            </div>

            <div>
                <p class="text-xs text-gray-400 uppercase font-medium mb-1">Nombre</p>
                <p class="text-gray-800">{{ $pedido->nombre }}</p>
            </div>

            <div>
                <p class="text-xs text-gray-400 uppercase font-medium mb-1">Apellido</p>
                <p class="text-gray-800">{{ $pedido->apellido }}</p>
            </div>

            <div>
                <p class="text-xs text-gray-400 uppercase font-medium mb-1">Precio</p>
                <p class="text-orange-500 font-bold text-lg">${{ number_format($pedido->precio, 2) }}</p>
            </div>

            <div>
                <p class="text-xs text-gray-400 uppercase font-medium mb-1">Fecha de carga</p>
                <p class="text-gray-800">{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <div>
                <p class="text-xs text-gray-400 uppercase font-medium mb-1">Estado del pedido</p>
                @if($pedido->estado_pedido == 'disponible')
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">Disponible</span>
                @else
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">Entregado</span>
                @endif
            </div>

            <div>
                <p class="text-xs text-gray-400 uppercase font-medium mb-1">Estado de pago</p>
                @if($pedido->estado_pago == 'pagado')
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">Pagado</span>
                @else
                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">No pagado</span>
                @endif
            </div>

            @if($pedido->estado_pago == 'pagado')
                <div>
                    <p class="text-xs text-gray-400 uppercase font-medium mb-1">Tipo de pago</p>
                    @if($pedido->tipo_pago == 'efectivo')
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-medium">Efectivo</span>
                    @else
                        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-medium">Transferencia</span>
                    @endif
                </div>
            @endif

        </div>

        <div class="mt-8 flex gap-3 border-t border-gray-100 pt-6">
            <a href="{{ route('pedidos.edit', $pedido) }}"
               class="flex-1 sm:flex-none text-center bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                Editar pedido
            </a>
            <form method="POST" action="{{ route('pedidos.destroy', $pedido) }}"
                  onsubmit="return confirm('¿Eliminar este pedido?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="flex-1 sm:flex-none border border-red-300 text-red-500 hover:bg-red-50 px-6 py-2 rounded-lg text-sm font-medium transition">
                    Eliminar
                </button>
            </form>
        </div>

    </div>

@endsection
