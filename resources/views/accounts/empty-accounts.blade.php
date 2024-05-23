<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <br> <br>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-center">
                        <a href="/">
                            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                        </a>
                    </div>
                    <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center justify-center">Seja bem-vindo!</h1>

                    <div class="text-center mt-8">
                        <p class="text-lg text-gray-600 dark:text-gray-300">Você ainda não possui contas cadastradas.</p>    
                        <button data-modal-target="add-account-modal" data-modal-toggle="add-account-modal" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-10 rounded mt-6">Cadastrar Conta</button>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@include('accounts.form-modal')

{{-- Modal script --}}
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
