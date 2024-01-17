{{-- <x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ativos') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">           
            <a href="{{ route('assets.reloadData') }}">
                <button class="fixed bottom-4 right-4 bg-blue-700 hover:bg-blue-500 text-white font-bold py-2 px-10 rounded">O</button>
            </a>

            <br>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="#" method="POST">
                        @csrf
                        @include('assets.asset-table')
                    </form>  
                </div>
            </div>
            <br>
                <a href="{{ route('assets.create') }}">
                    <button class="bg-purple-700 hover:bg-purple-500 text-white font-bold py-2 px-10 rounded">Cadastrar Ativo</button>
                </a>
        </div>
    </div>
</x-app-layout> --}}

<x-app-layout>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="w-full grid grid-cols-3 gap-4">
                        <!-- Caixa 1 (à esquerda) -->
                        <div class="bg-gray-700 rounded-lg p-4">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white">Variação de Hoje</h2>
                            @if ($processedData[0]['total_values'] > 0)
                                <p class="text-xl font-semibold text-green-500">
                            @else
                                <p class="text-xl font-semibold text-red-500">
                            @endif
                                R$ {{ $processedData[0]['total_values'] }}
                            </p>
                        </div>
                    
                        <!-- Caixa 2 (no centro) -->
                        <div class="bg-gray-700 rounded-lg p-4">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white">Variação Total</h2>
                            @if ($processedData[1]['total_values'] > 0)
                                <p class="text-xl font-semibold text-green-500">
                            @else
                                <p class="text-xl font-semibold text-red-500">
                            @endif
                                R$ {{ $processedData[1]['total_values'] }}
                            </p>
                        </div>
                    
                        <!-- Caixa 3 (à direita) -->
                        <div class="bg-gray-700 rounded-lg p-4">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white">Saldo Total</h2>
                            @if ($processedData[2]['total_values'] > 0)
                                <p class="text-xl font-semibold text-green-500">
                            @else
                                <p class="text-xl font-semibold text-red-500">
                            @endif
                                R$ {{ $processedData[2]['total_values'] }}
                            </p>
                        </div>
                    </div>
                    
                    
                    
                </div>
            </div>
        </div>
    </div>

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
            <button data-modal-target="form-modal" data-modal-toggle="form-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-5" type="button">
                Cadastrar Ativo
            </button>
        </div>

</x-app-layout>

@include('assets.form-modal')
@include('assets.delete-modal')


{{-- Modal script --}}
<script>
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