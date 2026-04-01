<nav x-data="{ open: false }" class="bg-gradient-to-r from-orange-400 to-orange-500 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-6 py-3">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="{{ route('pedidos.index') }}" class="flex items-center gap-3 group">
                    <div class="bg-white rounded-lg p-1.5 shadow-md border-2 border-white group-hover:border-orange-200 transition-all duration-200">
                        <img src="{{ asset('images/logo.png') }}" alt="DF Cases" class="h-7 w-7 object-contain">
                    </div>
                    <span class="text-white font-bold text-xl hidden sm:block group-hover:text-orange-100 transition-colors">DF Cases</span>
                </a>

                <!-- Navigation Links - Desktop -->
                <div class="hidden lg:flex items-center gap-2">
                    <a href="{{ route('pedidos.index') }}"
                       class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('pedidos.index') ? 'bg-white text-orange-500 shadow-md' : 'text-white hover:bg-white/20' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Pedidos
                    </a>

                    <a href="{{ route('pedidos.dashboard') }}"
                       class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('pedidos.dashboard') ? 'bg-white text-orange-500 shadow-md' : 'text-white hover:bg-white/20' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Estadísticas
                    </a>

                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('users.index') }}"
                       class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-white text-orange-500 shadow-md' : 'text-white hover:bg-white/20' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Usuarios
                    </a>
                    @endif
                </div>
            </div>

            <!-- Right Side - Desktop -->
            <div class="hidden lg:flex items-center gap-3">
                <!-- User Dropdown -->
                <x-dropdown align="right" width="64">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 text-white hover:bg-white/20 group">
                            <!-- Avatar con indicador online -->
                            <div class="relative">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=ffffff&color=f97316&size=128&font-size=0.5&bold=true"
                                     alt="{{ Auth::user()->name }}"
                                     class="w-9 h-9 rounded-full border-2 border-white shadow-lg group-hover:border-orange-200 transition-all">
                                <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></div>
                            </div>

                            <span class="hidden xl:block group-hover:text-orange-100 transition-colors">{{ Auth::user()->name }}</span>

                            <svg class="w-4 h-4 group-hover:text-orange-100 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Header del dropdown -->
                        <div class="px-5 py-4 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-orange-100">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=f97316&color=ffffff&size=128&font-size=0.5&bold=true"
                                         alt="{{ Auth::user()->name }}"
                                         class="w-12 h-12 rounded-full border-2 border-orange-300 shadow-md">
                                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></div>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">{{ Auth::user()->name }}</div>
                                    <div class="text-sm text-gray-600">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Opciones del menú -->
                        <div class="py-2">
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-3 px-5 py-3 hover:bg-orange-50 transition-colors group">
                                <div class="p-2 bg-gray-100 rounded-lg group-hover:bg-orange-100 transition-colors">
                                    <svg class="w-4 h-4 text-gray-600 group-hover:text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">Mi Perfil</div>
                                    <div class="text-xs text-gray-500">Configuración de cuenta</div>
                                </div>
                            </x-dropdown-link>

                            <!-- Separador -->
                            <div class="border-t border-gray-100 my-2"></div>

                            <!-- Cerrar sesión -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 hover:bg-red-50 transition-colors group text-left">
                                    <div class="p-2 bg-red-50 rounded-lg group-hover:bg-red-100 transition-colors">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-red-600">Cerrar Sesión</div>
                                        <div class="text-xs text-red-500">Salir de la cuenta</div>
                                    </div>
                                </button>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Menu - Mobile -->
            <div class="flex lg:hidden">
                <button @click="open = !open" class="p-2.5 rounded-xl text-white hover:bg-white/20 transition-all duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden lg:hidden bg-white shadow-lg">
        <!-- Navigation Links -->
        <div class="py-3 space-y-1 border-b border-gray-100">
            <a href="{{ route('pedidos.index') }}"
               class="flex items-center gap-3 mx-3 px-4 py-3 rounded-xl text-base font-semibold transition-all {{ request()->routeIs('pedidos.index') ? 'bg-orange-50 text-orange-600' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Pedidos
            </a>

            <a href="{{ route('pedidos.dashboard') }}"
               class="flex items-center gap-3 mx-3 px-4 py-3 rounded-xl text-base font-semibold transition-all {{ request()->routeIs('pedidos.dashboard') ? 'bg-orange-50 text-orange-600' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Estadísticas
            </a>

            @if(Auth::user()->isAdmin())
            <a href="{{ route('users.index') }}"
               class="flex items-center gap-3 mx-3 px-4 py-3 rounded-xl text-base font-semibold transition-all {{ request()->routeIs('users.*') ? 'bg-orange-50 text-orange-600' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Usuarios
            </a>
            @endif
        </div>

        <!-- User Section -->
        <div class="py-4 bg-gray-50">
            <!-- User Info -->
            <div class="px-6 mb-3">
                <div class="flex items-center gap-3 p-3 bg-white rounded-xl shadow-sm">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=f97316&color=ffffff&size=128&font-size=0.5&bold=true"
                             alt="{{ Auth::user()->name }}"
                             class="w-12 h-12 rounded-full border-2 border-orange-200">
                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></div>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-gray-900">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <!-- Menu Options -->
            <div class="px-3 space-y-1">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-white transition-all">
                    <div class="p-2 bg-gray-100 rounded-lg">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold">Mi Perfil</div>
                        <div class="text-xs text-gray-500">Configuración de cuenta</div>
                    </div>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-all">
                        <div class="p-2 bg-red-50 rounded-lg">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-left">Cerrar Sesión</div>
                            <div class="text-xs text-red-500 text-left">Salir de la cuenta</div>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
