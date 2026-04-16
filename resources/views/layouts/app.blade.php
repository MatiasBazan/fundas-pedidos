<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DF Cases</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</head>
<body class="bg-[#FFF0F5] antialiased" x-data="{ sidebarOpen: false }">

{{-- Sidebar overlay (mobile) --}}
<div x-show="sidebarOpen"
     x-transition:enter="transition-opacity ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="sidebarOpen = false"
     class="fixed inset-0 bg-black/50 z-40 md:hidden"
     style="display:none"></div>

{{-- Sidebar --}}
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 w-64 bg-[#1A0A10] z-50 flex flex-col transition-transform duration-300 ease-in-out md:translate-x-0 select-none">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-5 py-5 border-b border-white/10">
        <div class="bg-[#FF2D6B] rounded-xl p-2 shadow-lg shadow-[#FF2D6B]/30 flex-shrink-0">
            <img src="{{ asset('images/logo.png') }}" alt="DF Cases" class="h-8 w-8 object-contain">
        </div>
        <div>
            <span class="text-white font-bold text-lg leading-none block">DF Cases</span>
            <span class="text-gray-500 text-xs">Gestión de pedidos</span>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">

        <p class="px-3 text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Módulos</p>

        <a href="{{ route('compras.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 group
                  {{ request()->routeIs('compras.*') ? 'bg-[#FF2D6B] text-white shadow-md shadow-[#FF2D6B]/25' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Compras
        </a>

        <a href="{{ route('stock.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 group
                  {{ request()->routeIs('stock.*') ? 'bg-[#FF2D6B] text-white shadow-md shadow-[#FF2D6B]/25' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            Stock
        </a>

        <a href="{{ route('pedidos.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 group
                  {{ request()->routeIs('pedidos.*') ? 'bg-[#FF2D6B] text-white shadow-md shadow-[#FF2D6B]/25' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Pedidos
        </a>

        <a href="{{ route('stats.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 group
                  {{ request()->routeIs('stats.*') ? 'bg-[#FF2D6B] text-white shadow-md shadow-[#FF2D6B]/25' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Estadísticas
        </a>

        @if(Auth::user()->isAdmin())
        <div class="pt-3 mt-3 border-t border-white/10">
            <p class="px-3 text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Admin</p>
            <a href="{{ route('users.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 group
                      {{ request()->routeIs('users.*') ? 'bg-[#FF2D6B] text-white shadow-md shadow-[#FF2D6B]/25' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Usuarios
            </a>
        </div>
        @endif
    </nav>

    {{-- User + logout --}}
    <div class="border-t border-white/10 p-4">
        <div class="flex items-center gap-3 mb-3 px-1">
            <div class="w-8 h-8 bg-[#FF2D6B] rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0 shadow-sm">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-white text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                <p class="text-gray-500 text-xs truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-2 px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg transition-all">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Cerrar sesión
            </button>
        </form>
    </div>
</aside>

{{-- Main area --}}
<div class="md:ml-64 min-h-screen flex flex-col">

    {{-- Topbar --}}
    <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div class="flex items-center gap-4 px-6 h-14">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="md:hidden p-2 -ml-2 rounded-lg text-gray-500 hover:text-gray-900 hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="md:hidden flex items-center gap-2">
                <div class="bg-[#FF2D6B] rounded-lg p-1.5">
                    <img src="{{ asset('images/logo.png') }}" alt="DF Cases" class="h-5 w-5 object-contain">
                </div>
                <span class="font-bold text-gray-900 text-sm">DF Cases</span>
            </div>
        </div>

        @if(session('impersonating_admin_id'))
        <div class="bg-blue-600 text-white text-xs py-2 px-6 flex items-center justify-between">
            <span class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Viendo como <strong class="ml-0.5">{{ Auth::user()->name }}</strong>
            </span>
            <form method="POST" action="{{ route('impersonate.stop') }}">
                @csrf
                <button type="submit" class="bg-white text-blue-600 font-semibold text-xs px-3 py-1 rounded-lg hover:bg-blue-50 transition">
                    Volver a mi cuenta
                </button>
            </form>
        </div>
        @endif
    </header>

    {{-- Flash --}}
    @if(session('success'))
    <div class="px-6 pt-5">
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-3 text-sm shadow-sm">
            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    {{-- Content --}}
    <main class="flex-1 p-6">
        @yield('content')
    </main>

    <footer class="px-6 py-3 border-t border-gray-100">
        <p class="text-xs text-gray-400">© {{ date('Y') }} DF Cases</p>
    </footer>
</div>

</body>
</html>
