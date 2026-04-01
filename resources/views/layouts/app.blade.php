<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DF Cases - Gestión de Pedidos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</head>
<body class="bg-gray-50 min-h-screen">

<!-- Navbar -->
<nav class="bg-gradient-to-r from-orange-400 to-orange-500 shadow-lg">
    <div class="max-w-7xl mx-auto px-6 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <div class="bg-white rounded-xl p-2 shadow-lg border-2 border-gray-500">
                    <img src="{{ asset('images/logo.png') }}" alt="DF Cases" class="h-10 w-10 object-contain">
                </div>
                <span class="text-white font-bold text-2xl hidden sm:block">DF Cases</span>
            </div>

            <!-- Enlaces de navegación -->
            <div class="flex items-center gap-2">
                <a href="{{ route('pedidos.index') }}"
                   class="px-5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 {{ request()->routeIs('pedidos.index') ? 'bg-white text-orange-500 shadow-md' : 'text-white hover:bg-white/20' }}">
                    Pedidos
                </a>
                <a href="{{ route('pedidos.dashboard') }}"
                   class="px-5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 {{ request()->routeIs('pedidos.dashboard') ? 'bg-white text-orange-500 shadow-md' : 'text-white hover:bg-white/20' }}">
                    Estadísticas
                </a>
                @if(Auth::user()->isAdmin())
                <a href="{{ route('users.index') }}"
                   class="px-5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-white text-orange-500 shadow-md' : 'text-white hover:bg-white/20' }}">
                    Usuarios
                </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="ml-2">
                    @csrf
                    <button type="submit"
                            class="bg-white text-orange-500 hover:bg-orange-50 px-5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2 border border-orange-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

@if(session('impersonating_admin_id'))
<div class="bg-blue-600 text-white text-sm py-2 px-6">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <span>
            <svg class="w-4 h-4 inline mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            Estás viendo la app como <strong>{{ Auth::user()->name }}</strong>
        </span>
        <form method="POST" action="{{ route('impersonate.stop') }}">
            @csrf
            <button type="submit" class="bg-white text-blue-600 font-semibold text-xs px-3 py-1 rounded-lg hover:bg-blue-50 transition">
                Volver a mi cuenta
            </button>
        </form>
    </div>
</div>
@endif

<!-- Contenido -->
<main class="max-w-7xl mx-auto px-6 py-8">

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-r-lg shadow-sm flex items-center gap-3">
            <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @yield('content')
</main>

</body>
</html>
