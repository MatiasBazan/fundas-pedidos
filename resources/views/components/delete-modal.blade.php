{{-- Modal de confirmación de eliminación --}}
<div id="deleteModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm transform transition-all">
        <div class="p-6">
            <div class="flex items-start gap-4 mb-4">
                <div class="bg-red-100 p-3 rounded-xl flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">¿Eliminar este registro?</h3>
                    <p class="text-sm text-gray-500 mt-0.5" id="pedidoInfo"></p>
                </div>
            </div>
            <p class="text-sm text-gray-500 mb-6 ml-16">Esta acción no se puede deshacer.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold transition-colors">
                    Cancelar
                </button>
                <button onclick="confirmDelete()"
                        class="flex-1 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl text-sm font-semibold transition-colors shadow-sm">
                    Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let deleteForm = null;

    function showDeleteModal(form, info) {
        deleteForm = form;
        document.getElementById('pedidoInfo').textContent = info;
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
