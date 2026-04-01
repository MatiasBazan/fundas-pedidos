@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Usuarios</h1>
        <p class="text-sm text-gray-500 mt-1">Gestión de cuentas del sistema</p>
    </div>
    <a href="{{ route('users.create') }}"
       class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md transition-all duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nuevo usuario
    </a>
</div>

@if(session('error'))
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-r-lg shadow-sm flex items-center gap-3">
        <svg class="w-5 h-5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <span class="font-medium">{{ session('error') }}</span>
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-6 py-4 font-semibold text-gray-700">Nombre</th>
                <th class="text-left px-6 py-4 font-semibold text-gray-700">Email</th>
                <th class="text-left px-6 py-4 font-semibold text-gray-700">Rol</th>
                <th class="text-left px-6 py-4 font-semibold text-gray-700">Creado</th>
                <th class="px-6 py-4"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=f97316&color=ffffff&size=64&font-size=0.5&bold=true"
                             alt="{{ $user->name }}"
                             class="w-9 h-9 rounded-full border-2 border-orange-200">
                        <div>
                            <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                            @if($user->id === auth()->id())
                                <div class="text-xs text-orange-500 font-medium">Vos</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                <td class="px-6 py-4">
                    @if($user->role === 'admin')
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                            Admin
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                            Usuario
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 text-gray-500">{{ $user->created_at->format('d/m/Y') }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('impersonate.start', $user) }}">
                            @csrf
                            <button type="submit" title="Entrar como {{ $user->name }}"
                                    class="p-2 rounded-lg text-gray-500 hover:text-blue-600 hover:bg-blue-50 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('users.edit', $user) }}"
                           class="p-2 rounded-lg text-gray-500 hover:text-orange-600 hover:bg-orange-50 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('users.destroy', $user) }}" class="delete-user-form">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                    data-info="{{ $user->name }} — {{ $user->email }}"
                                    onclick="showDeleteModal(this.closest('form'), this.dataset.info)"
                                    class="p-2 rounded-lg text-gray-500 hover:text-red-600 hover:bg-red-50 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                    No hay usuarios registrados.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{-- Modal eliminación --}}
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl p-6 max-w-sm mx-4">
        <div class="flex items-center gap-3 mb-4">
            <div class="bg-red-100 rounded-full p-3">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">¿Eliminar usuario?</h3>
                <p class="text-sm text-gray-500" id="userInfo"></p>
            </div>
        </div>
        <p class="text-gray-600 text-sm mb-6">Esta acción no se puede deshacer.</p>
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()"
                    class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition">
                Cancelar
            </button>
            <button onclick="confirmDelete()"
                    class="flex-1 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium transition">
                Eliminar
            </button>
        </div>
    </div>
</div>

<script>
    let deleteForm = null;

    function showDeleteModal(form, userInfo) {
        deleteForm = form;
        document.getElementById('userInfo').textContent = userInfo;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        deleteForm = null;
    }

    function confirmDelete() {
        if (deleteForm) deleteForm.submit();
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
</script>
@endsection
