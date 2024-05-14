<x-app-layout>
    
    
    <div class="max-w-2xl mt-10 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                @include('accounts.account-table')
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

</script>