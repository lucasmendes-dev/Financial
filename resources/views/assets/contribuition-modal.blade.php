<!-- Main modal -->
<div id="contribuition-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 flex items-center justify-center hidden z-50">
    <div class="relative w-full max-w-md bg-white rounded-lg shadow p-4 dark:bg-gray-700">
        <!-- Modal content -->
        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="contribuition-modal">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Fechar modal</span>
        </button>

        <div class="px-6 py-6 lg:px-8">
            <h3 class="mb-6 text-xl font-medium text-gray-900 dark:text-white">Novo Aporte - {{ $asset->code }} </h3>
            <p class="mb-6 text-gray-300 dark:text-gray">Insira a quantidade e preço médio das novas cotas que você comprou e seu ativo será atualizado com os valores calculados.</p>
            <form class="space-y-6" action="{{ route('assets.contribuition', $asset->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="flex space-x-4">
                    <div class="w-1/2">
                        <label for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Código do Ativo</label>
                        <input value="{{ $asset->code }}" type="text" name="code" id="code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" readonly required">
                    </div>
                    <div class="w-1/2">
                        <label for="average_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Preço Médio</label>
                        <input type="number" step="0.01" min="0" name="average_price" id="average_price" placeholder="R$ 00,00" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <div class="w-1/2">
                        <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantidade</label>
                        <input type="number" min="1" name="quantity" id="quantity" placeholder="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                </div>
        
                <button id="submitButton" type="submit" class="w-full text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">Cadastrar novo aporte</button>
            </form>
        </div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById('code');
        const submitButton = document.getElementById('submitButton');

        submitButton.addEventListener("click", function () {
            if (modal.value == null || modal.value == '') {
                alert("O campo 'Código do Ativo' não pode estar vazio!");
            }
        });
    });
</script>
