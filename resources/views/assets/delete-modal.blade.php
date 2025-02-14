<div id="delete-confirmation-modal" tabindex="-1" class="fixed inset-0 flex items-center justify-center hidden z-50">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="p-6 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Tem certeza que deseja excluir este ativo?</h3>
                <button id="delete-confirm-button" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                    Sim, tenho certeza
                </button>
                <button id="delete-cancel-button"data-modal-hide="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Não, cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll('.delete-button');
        const deleteConfirmationModal = document.getElementById('delete-confirmation-modal');
        const deleteConfirmButton = document.getElementById('delete-confirm-button');
        const deleteCancelButton = document.getElementById('delete-cancel-button');

        let deleteRecordId = null;

        function showDeleteConfirmationModal(recordId) {
            deleteRecordId = recordId;
            deleteConfirmationModal.classList.remove('hidden');
        }

        deleteButtons.forEach((button) => {
            button.addEventListener('click', function () {
                const recordId = this.getAttribute('data-record-id');
                showDeleteConfirmationModal(recordId);
            });
        });

        deleteConfirmButton.addEventListener('click', function () {
            if (deleteRecordId !== null) {
                fetch(`/assets/${deleteRecordId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => {
                    window.location.reload();
                });
            }
        });

        deleteCancelButton.addEventListener('click', function () {
            deleteConfirmationModal.classList.add('hidden');
        });
    });
</script>
