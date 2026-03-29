{{-- Modal de confirmación de eliminación --}}
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm mx-4 transform transition-all">
        <div class="flex items-center gap-3 mb-4">
            <div class="bg-red-100 rounded-full p-3">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">¿Eliminar pedido?</h3>
                <p class="text-sm text-gray-500" id="pedidoInfo"></p>
            </div>
        </div>
        <p class="text-gray-600 text-sm mb-6">Esta acción no se puede deshacer.</p>
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()"
                    class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition">
                Cancelar
            </button>
            <button onclick="confirmDelete()"
                    class="flex-1 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium transition">
                Eliminar
            </button>
        </div>
    </div>
</div>

<script>
    let deleteForm = null;

    function showDeleteModal(form, pedidoInfo) {
        deleteForm = form;
        document.getElementById('pedidoInfo').textContent = pedidoInfo;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        deleteForm = null;
    }

    function confirmDelete() {
        if (deleteForm) {
            deleteForm.submit();
        }
    }

    // Cerrar modal al hacer click fuera
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Cerrar modal con tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
