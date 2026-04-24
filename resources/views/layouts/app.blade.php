<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DF Cases</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</head>
<body class="bg-[#FFF0F5] antialiased" x-data="{ sidebarOpen: false }">

{{-- Loading bar --}}
<div id="df-loader" style="position:fixed;top:0;left:0;right:0;height:3px;z-index:99999;pointer-events:none;opacity:0">
    <div id="df-loader-bar" style="height:100%;width:0;background:#FF2D6B;border-radius:0 2px 2px 0;box-shadow:0 0 8px #FF2D6B88;transition:none"></div>
</div>

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
            Ventas
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

    {{-- Daily Bible Verse --}}
    @php
        $versiculos = [
            ['texto' => 'Porque de tal manera amó Dios al mundo, que ha dado a su Hijo unigénito, para que todo aquel que en él cree, no se pierda, mas tenga vida eterna.', 'cita' => 'Juan 3:16'],
            ['texto' => 'Todo lo puedo en Cristo que me fortalece.', 'cita' => 'Filipenses 4:13'],
            ['texto' => 'Confía en el Señor con todo tu corazón, y no te apoyes en tu propia prudencia.', 'cita' => 'Proverbios 3:5'],
            ['texto' => 'El Señor es mi pastor, nada me faltará.', 'cita' => 'Salmos 23:1'],
            ['texto' => 'Esforzaos y cobrad ánimo; no temáis, ni tengáis miedo, porque Jehová tu Dios es el que va contigo.', 'cita' => 'Deuteronomio 31:6'],
            ['texto' => 'Mas buscad primeramente el reino de Dios y su justicia, y todas estas cosas os serán añadidas.', 'cita' => 'Mateo 6:33'],
            ['texto' => 'Jehová te bendiga, y te guarde; Jehová haga resplandecer su rostro sobre ti, y tenga de ti misericordia.', 'cita' => 'Números 6:24-25'],
            ['texto' => 'Y sabemos que a los que aman a Dios, todas las cosas les ayudan a bien.', 'cita' => 'Romanos 8:28'],
            ['texto' => 'Venid a mí todos los que estáis trabajados y cargados, y yo os haré descansar.', 'cita' => 'Mateo 11:28'],
            ['texto' => 'No temas, porque yo estoy contigo; no desmayes, porque yo soy tu Dios que te esfuerzo.', 'cita' => 'Isaías 41:10'],
            ['texto' => 'Encomienda a Jehová tu camino, y confía en él; y él hará.', 'cita' => 'Salmos 37:5'],
            ['texto' => 'La paz os dejo, mi paz os doy; yo no os la doy como el mundo la da.', 'cita' => 'Juan 14:27'],
            ['texto' => 'Clama a mí, y yo te responderé, y te enseñaré cosas grandes y ocultas que tú no conoces.', 'cita' => 'Jeremías 33:3'],
            ['texto' => 'Porque yo sé los pensamientos que tengo acerca de vosotros, pensamientos de paz, y no de mal.', 'cita' => 'Jeremías 29:11'],
            ['texto' => 'El ángel del Señor acampa alrededor de los que le temen, y los defiende.', 'cita' => 'Salmos 34:7'],
            ['texto' => 'Lámpara es a mis pies tu palabra, y lumbrera a mi camino.', 'cita' => 'Salmos 119:105'],
            ['texto' => 'De cierto, de cierto os digo: El que cree en mí, tiene vida eterna.', 'cita' => 'Juan 6:47'],
            ['texto' => 'Jehová peleará por vosotros, y vosotros estaréis tranquilos.', 'cita' => 'Éxodo 14:14'],
            ['texto' => 'Porque donde están dos o tres congregados en mi nombre, allí estoy yo en medio de ellos.', 'cita' => 'Mateo 18:20'],
            ['texto' => 'El Señor es bueno, fortaleza en el día de la angustia; y conoce a los que en él confían.', 'cita' => 'Nahúm 1:7'],
            ['texto' => 'Bienaventurados los misericordiosos, porque ellos alcanzarán misericordia.', 'cita' => 'Mateo 5:7'],
            ['texto' => 'El que habita al abrigo del Altísimo morará bajo la sombra del Omnipotente.', 'cita' => 'Salmos 91:1'],
            ['texto' => 'Los que esperan en Jehová tendrán nuevas fuerzas; levantarán alas como las águilas.', 'cita' => 'Isaías 40:31'],
            ['texto' => 'Yo soy el camino, la verdad y la vida; nadie viene al Padre sino por mí.', 'cita' => 'Juan 14:6'],
            ['texto' => 'Y la paz de Dios, que sobrepasa todo entendimiento, guardará vuestros corazones.', 'cita' => 'Filipenses 4:7'],
            ['texto' => 'Dad gracias en todo, porque esta es la voluntad de Dios para con vosotros.', 'cita' => 'I Tesalonicenses 5:18'],
            ['texto' => 'No os ha sobrevenido ninguna tentación que no sea humana; pero fiel es Dios.', 'cita' => 'I Corintios 10:13'],
            ['texto' => 'Jesús le dijo: Si puedes creer, al que cree todo le es posible.', 'cita' => 'Marcos 9:23'],
            ['texto' => 'Sean fuertes y valientes. No teman ni se asusten, porque el Señor su Dios siempre los acompañará.', 'cita' => 'Josué 1:9'],
            ['texto' => 'Echando toda vuestra ansiedad sobre él, porque él tiene cuidado de vosotros.', 'cita' => 'I Pedro 5:7'],
            ['texto' => 'Dios es nuestro amparo y fortaleza, nuestro pronto auxilio en las tribulaciones.', 'cita' => 'Salmos 46:1'],
            ['texto' => 'He aquí, yo estoy con vosotros todos los días, hasta el fin del mundo.', 'cita' => 'Mateo 28:20'],
            ['texto' => 'Pedid, y se os dará; buscad, y hallaréis; llamad, y se os abrirá.', 'cita' => 'Mateo 7:7'],
            ['texto' => 'El amor es paciente, es bondadoso. El amor no es envidioso ni jactancioso ni orgulloso.', 'cita' => 'I Corintios 13:4'],
            ['texto' => 'No se amolden al mundo actual, sino sean transformados mediante la renovación de su mente.', 'cita' => 'Romanos 12:2'],
            ['texto' => 'El Señor es mi luz y mi salvación; ¿de quién temeré?', 'cita' => 'Salmos 27:1'],
            ['texto' => 'Yo he venido para que tengan vida, y para que la tengan en abundancia.', 'cita' => 'Juan 10:10'],
            ['texto' => 'El principio de la sabiduría es el temor de Jehová.', 'cita' => 'Proverbios 9:10'],
            ['texto' => 'Bienaventurados los de limpio corazón, porque ellos verán a Dios.', 'cita' => 'Mateo 5:8'],
            ['texto' => 'Si Dios es por nosotros, ¿quién contra nosotros?', 'cita' => 'Romanos 8:31'],
            ['texto' => 'Mira que te mando que te esfuerces y seas valiente; no temas ni desmayes.', 'cita' => 'Josué 1:9'],
            ['texto' => 'Jehová es mi fortaleza y mi escudo; en él confió mi corazón, y fui ayudado.', 'cita' => 'Salmos 28:7'],
            ['texto' => 'El gozo del Señor es vuestra fuerza.', 'cita' => 'Nehemías 8:10'],
            ['texto' => 'Por nada estéis afanosos, sino sean conocidas vuestras peticiones delante de Dios.', 'cita' => 'Filipenses 4:6'],
            ['texto' => 'Y les enjugará Dios toda lágrima de los ojos; y ya no habrá muerte.', 'cita' => 'Apocalipsis 21:4'],
            ['texto' => 'Estas cosas os he hablado para que en mí tengáis paz. En el mundo tendréis aflicción; pero confiad, yo he vencido al mundo.', 'cita' => 'Juan 16:33'],
            ['texto' => 'Amarás al Señor tu Dios con todo tu corazón, y con toda tu alma, y con toda tu mente.', 'cita' => 'Mateo 22:37'],
            ['texto' => 'Porque el Señor da la sabiduría; de su boca viene el conocimiento y la inteligencia.', 'cita' => 'Proverbios 2:6'],
            ['texto' => 'Bendito el varón que confía en Jehová, y cuya confianza es Jehová.', 'cita' => 'Jeremías 17:7'],
            ['texto' => 'Alumbre vuestra luz delante de los hombres, para que vean vuestras buenas obras.', 'cita' => 'Mateo 5:16'],
            ['texto' => 'Y andad en amor, como también Cristo nos amó.', 'cita' => 'Efesios 5:2'],
            ['texto' => 'El Señor cumplirá en mí su propósito; tu misericordia, oh Señor, es para siempre.', 'cita' => 'Salmos 138:8'],
            ['texto' => 'Mejor es el fin del negocio que su principio; mejor es el sufrido de espíritu que el altivo.', 'cita' => 'Eclesiastés 7:8'],
            ['texto' => 'Bueno es Jehová a los que en él esperan, al alma que le busca.', 'cita' => 'Lamentaciones 3:25'],
            ['texto' => 'Gustad, y ved que es bueno Jehová; dichoso el hombre que confía en él.', 'cita' => 'Salmos 34:8'],
            ['texto' => 'Todo tiene su tiempo, y todo lo que se quiere debajo del cielo tiene su hora.', 'cita' => 'Eclesiastés 3:1'],
            ['texto' => 'He peleado la buena batalla, he acabado la carrera, he guardado la fe.', 'cita' => 'II Timoteo 4:7'],
            ['texto' => 'Sobre toda cosa guardada, guarda tu corazón; porque de él mana la vida.', 'cita' => 'Proverbios 4:23'],
            ['texto' => 'El que comenzó en vosotros la buena obra, la perfeccionará hasta el día de Jesucristo.', 'cita' => 'Filipenses 1:6'],
            ['texto' => 'Hermanos míos, tened por sumo gozo cuando os halléis en diversas pruebas.', 'cita' => 'Santiago 1:2'],
        ];
        $versiculoDelDia = $versiculos[date('z') % count($versiculos)];
    @endphp

    <div class="px-6 pt-4" id="versiculo-banner" style="animation: versiculoFadeIn 0.8s ease-out">
        <div class="bg-gradient-to-r from-amber-50 via-orange-50 to-yellow-50 border border-amber-200/60 rounded-xl px-5 py-3 flex items-start gap-3 shadow-sm">
            {{-- Book icon --}}
            <div class="flex-shrink-0 mt-0.5">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm text-amber-900/80 leading-relaxed italic">
                    "{{ $versiculoDelDia['texto'] }}"
                </p>
                <p class="text-xs text-amber-600/70 font-semibold mt-1">
                    — {{ $versiculoDelDia['cita'] }}
                </p>
            </div>
        </div>
    </div>

    <style>
        @keyframes versiculoFadeIn {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>

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

    @if(session('error'))
    <div class="px-6 pt-5">
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center gap-3 text-sm shadow-sm">
            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span class="font-medium">{{ session('error') }}</span>
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

{{-- Delete modal (global) --}}
<div id="df-delete-modal"
     class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-[9998] p-4"
     onclick="if(event.target===this) closeDeleteModal()">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm transform transition-all">
        <div class="p-6">
            <div class="flex items-start gap-4 mb-4">
                <div class="bg-red-100 p-3 rounded-xl flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">¿Estás seguro?</h3>
                    <p class="text-sm text-gray-500 mt-0.5" id="df-delete-info"></p>
                </div>
            </div>
            <p class="text-sm text-gray-500 mb-6 ml-[3.75rem]">Esta acción no se puede deshacer.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold transition-colors">
                    Cancelar
                </button>
                <button onclick="confirmDelete()"
                        class="flex-1 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl text-sm font-semibold transition-colors shadow-sm">
                    Sí, eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
/* ── TomSelect ─────────────────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('select[data-ts]').forEach(function (el) {
        new TomSelect(el, { create: false, allowEmptyOption: true, maxOptions: 300 });
    });
});

/* ── Loading bar ───────────────────────────────────────────────────────── */
var dfStartLoader = (function () {
    var loader = document.getElementById('df-loader');
    var bar    = document.getElementById('df-loader-bar');
    if (!loader || !bar) return function () {};

    function startLoader() {
        loader.style.transition = 'none';
        loader.style.opacity    = '1';
        bar.style.transition    = 'none';
        bar.style.width         = '0%';
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                bar.style.transition = 'width 0.3s ease';
                bar.style.width      = '80%';
                setTimeout(function () {
                    bar.style.transition = 'width 4s cubic-bezier(0.05, 0.9, 0.1, 1)';
                    bar.style.width      = '95%';
                }, 320);
            });
        });
        try { sessionStorage.setItem('df_nav', '1'); } catch(e) {}
    }

    function completeLoader() {
        var was;
        try { was = sessionStorage.getItem('df_nav'); sessionStorage.removeItem('df_nav'); } catch(e) {}
        if (!was) return;
        bar.style.transition = 'width 0.15s ease';
        bar.style.width      = '100%';
        setTimeout(function () {
            loader.style.transition = 'opacity 0.3s ease';
            loader.style.opacity    = '0';
            setTimeout(function () {
                bar.style.transition    = 'none';
                bar.style.width         = '0%';
                loader.style.transition = '';
            }, 300);
        }, 150);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', completeLoader);
    } else {
        completeLoader();
    }

    document.addEventListener('click', function (e) {
        var a = e.target.closest('a[href]');
        if (!a) return;
        var h = a.href || '';
        if (!h
            || a.target === '_blank'
            || h.startsWith('javascript')
            || h.startsWith('mailto')
            || h.indexOf(location.origin) !== 0
            || h.split('#')[0] === location.href.split('#')[0]) return;
        startLoader();
    }, true);

    document.addEventListener('submit', function () {
        startLoader();
    }, true);

    return startLoader;
})();

/* ── Delete modal ──────────────────────────────────────────────────────── */
var _deleteForm = null;

function showDeleteModal(form, info) {
    _deleteForm = form;
    document.getElementById('df-delete-info').textContent = info || '';
    document.getElementById('df-delete-modal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('df-delete-modal').classList.add('hidden');
    _deleteForm = null;
}

function confirmDelete() {
    if (!_deleteForm) return;
    dfStartLoader();
    _deleteForm.submit();
}

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeDeleteModal();
});

/* ── Bloquear scroll en inputs numéricos ──────────────────────────────── */
document.addEventListener('wheel', function (e) {
    if (document.activeElement && document.activeElement.type === 'number') {
        document.activeElement.blur();
    }
}, { passive: true });
</script>
</body>
</html>
