<x-guest-layout>
<div class="w-full max-w-sm">

    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Logo + título --}}
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-[#FF2D6B] rounded-2xl shadow-lg shadow-[#FF2D6B]/25 mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="DF Cases" class="w-10 h-10 object-contain">
        </div>
        <h1 class="text-2xl font-bold text-[#FF2D6B]">DF Cases</h1>
        <p class="text-sm text-gray-400 mt-1">Iniciá sesión para continuar</p>
    </div>

    {{-- Card --}}
    <div class="bg-white border border-gray-100 rounded-2xl shadow-xl px-8 py-8">

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-600 mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autofocus autocomplete="username"
                       placeholder="tu@email.com"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all @error('email') border-red-300 bg-red-50 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-600 mb-1.5">Contraseña</label>
                <input id="password" type="password" name="password"
                       required autocomplete="current-password"
                       placeholder="••••••••"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FF2D6B]/20 focus:border-[#FF2D6B] transition-all @error('password') border-red-300 bg-red-50 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember + forgot --}}
            <div class="flex items-center justify-between">
                <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="w-4 h-4 rounded border-gray-300 text-[#FF2D6B] focus:ring-[#FF2D6B]/20">
                    <span class="text-sm text-gray-500">Recordarme</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-[#FF2D6B] hover:text-[#E0245E] transition-colors">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full bg-[#FF2D6B] hover:bg-[#E0245E] text-white py-2.5 rounded-xl text-sm font-semibold transition-all shadow-sm shadow-[#FF2D6B]/25 flex items-center justify-center gap-2 group">
                <span>Iniciar sesión</span>
                <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </button>

        </form>
    </div>

    <p class="text-center text-xs text-gray-400 mt-6">© {{ date('Y') }} DF Cases</p>

</div>
</x-guest-layout>
