<x-app-layout>
    
    @include('assets.variation-summary');

    @include('assets.tabs');

        @if (!empty($stocks->all()))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @include('assets.stock-table')
                </div>
            </div>
        </div>
        @endif
        <br>
        @if (!empty($reit->all()))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @include('assets.fii-table')
                </div>
            </div>
        </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex items-center justify-end">
            
            <button data-modal-target="form-modal" data-modal-toggle="form-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-5 mr-4" type="button">
                Cadastrar Ativo
            </button>

            <div id="loader" class="hidden fixed inset-0 bg-gray-400 bg-opacity-75 flex items-center justify-center">
                <div class="loader"></div>
            </div>

            <button id="reloadButton" class="block text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800 mt-5">
                Atualizar
            </button>
            {{-- <a href="{{ route('assets.reloadData')}}">test button</a> --}}
        </div>

</x-app-layout>

@include('assets.form-modal')
@include('assets.delete-modal')


{{-- Modal script --}}
<script>

    //Create
    document.addEventListener("DOMContentLoaded", function () {
        const modalButton = document.querySelector('[data-modal-toggle="form-modal"]');
        const modal = document.getElementById('form-modal');

        modalButton.addEventListener("click", function () {
            modal.classList.toggle('hidden');
        });

        const closeButton = document.querySelector('[data-modal-hide="form-modal"]');
        closeButton.addEventListener("click", function () {
            modal.classList.toggle('hidden');
        });
    });


    //Delete
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

    //reload data
    document.getElementById('reloadButton').addEventListener('click', function() {

        document.getElementById('loader').classList.remove('hidden');

        fetch('/assets/reloadData', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            redirect: 'follow' //allow redirect
        }).then(response => {
            if (response.redirected) {
                window.location.href = response.url;
            } else {
                document.getElementById('loader').classList.add('hidden');
            }
        }).catch(error => {
            document.getElementById('loader').classList.add('hidden');
            console.error('Erro:', error);
        });
    });
    
</script>