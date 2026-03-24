<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DF Cases - Gestión de Pedidos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

<!-- Navbar -->
<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="DF Cases" class="h-12 w-auto">
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('pedidos.index') }}"
               class="text-gray-600 hover:text-orange-500 font-medium transition">
                Pedidos
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Contenido -->
<main class="max-w-7xl mx-auto px-4 py-6">

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</main>

</body>
</html>
