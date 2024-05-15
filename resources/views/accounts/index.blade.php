<x-app-layout>

    <div class="max-w-2xl mt-10 sm:px-6 lg:px-8">
        <div class="flex">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @include('accounts.account-table')
                </div>
            </div>

            <div width="50" height="25">
                <canvas id="accountChart" ></canvas>
            </div>
        </div>  
        <div class="max-w-7xl mx-auto flex items-center justify-end">
            <button data-modal-target="add-account-modal" data-modal-toggle="add-account-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-5" type="button">
                Cadastrar Conta
            </button>
        </div>
    </div>    

</x-app-layout>

@include('accounts.form-modal')
@include('accounts.delete-modal')


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    //Create
    document.addEventListener("DOMContentLoaded", function () {
        const modalButton = document.querySelector('[data-modal-toggle="add-account-modal"]');
        const modal = document.getElementById('add-account-modal');

        modalButton.addEventListener("click", function () {
            modal.classList.toggle('hidden');
        });

        const closeButton = document.querySelector('[data-modal-hide="add-account-modal"]');
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
                fetch(`/accounts/${deleteRecordId}`, {
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

    //Chart
    const ctx = document.getElementById('accountChart');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                borderWidth: 1
            }]
        },
        options: {
        
        }
    });

</script>