<x-app-layout>
    <div class="max-w-6xl mt-10 sm:px-6 lg:px-8 flex flex-row gap-4">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg order-1"> 
            <div class="p-6 text-gray-900 dark:text-gray-100">
                @include('accounts.account-table')
            </div>
            <button data-modal-target="add-account-modal" data-modal-toggle="add-account-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-5" type="button">
                Cadastrar Conta
            </button>
        </div>
        <canvas id="accountChart" class="order-2"></canvas> 
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
    const ctx = document.getElementById('accountChart').getContext('2d');

    //data from laravel controller
    const accountNames = @json($account_names);
    const accountBalances = @json($account_balances);

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: accountNames,
            datasets: [{
                label: 'Account Balances',
                data: accountBalances,
                borderWidth: 1,
                backgroundColor: [
                    'rgba(87, 35, 100, 1)',
                    'rgb(255, 0, 170)',
                    'rgba(0, 153, 204, 1)',
                    'rgba(0, 128, 0, 1)',
                    'rgba(153, 153, 153, 1)',
                    'rgba(25, 25, 25)',
                ],

            }]
        },
        options: {
            // Adicione opções aqui se precisar
        }
    });

</script>