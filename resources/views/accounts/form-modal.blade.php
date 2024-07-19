<!-- Main modal -->
<div id="add-account-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 flex items-center justify-center hidden z-50">
    <div class="relative w-full max-w-md bg-white rounded-lg shadow p-4 dark:bg-gray-700">
        <!-- Modal content -->
        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="add-account-modal">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Fechar modal</span>
        </button>

        <div class="px-6 py-6 lg:px-8">
            <h3 class="mb-6 text-xl font-medium text-gray-900 dark:text-white">Cadastrar nova conta</h3>
            <form class="space-y-6" action="{{ route('accounts.store') }}" method="POST">
                @csrf
                <div>
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecione a Conta</label>
                        <div class="relative">
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pl-12 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Digite o nome da conta" required oninput="filterAccounts()">
                        </div>
                        <ul id="account-list" class="mt-2 bg-white border border-gray-300 rounded-lg shadow-lg max-h-48 overflow-y-auto dark:bg-gray-700 dark:border-gray-600 hidden"></ul>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <div class="w-1/2">
                        <label for="balance" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Saldo Inicial (R$)</label>
                        <input type="number" step="0.01" name="balance" id="balance" placeholder="Ex: 2.366,12" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    <div class="w-1/2">
                        <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo</label>
                        <select name="type" id="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            <option value="current">Corrente</option>
                            <option value="savings">Poupança</option>
                            <option value="broker">Corretora</option>
                            <option value="ticket">Ticket</option>
                            <option value="crypto">Cripto</option>
                        </select>
                    </div>
                </div>
        
                <button id="submitButton" type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cadastrar</button>
            </form>
        </div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById('name');
        const submitButton = document.getElementById('submitButton');

        submitButton.addEventListener("click", function () {
            if (modal.value == null || modal.value == '') {
                alert("O campo 'Nome da conta' não pode estar vazio!");
            }
        });
    });

    const accounts = [
        { name: "Alelo", logo: "/img/account/Alelo.png" },
        { name: "Banco do Brasil", logo: "/img/account/Banco do Brasil.png" },
        { name: "Bradesco", logo: "/img/account/Bradesco.png" },
        { name: "BTG", logo: "/img/account/BTG.png" },
        { name: "C6 Bank", logo: "/img/account/C6 Bank.png" },
        { name: "Caixa", logo: "/img/account/Caixa.png" },
        { name: "Clear", logo: "/img/account/Clear.png" },
        { name: "Flash", logo: "/img/account/Flash.png" },
        { name: "Inter", logo: "/img/account/Inter.png" },
        { name: "Itaú", logo: "/img/account/Itaú.png" },
        { name: "Nubank - Saldo Separado", logo: "/img/account/Nubank - Saldo Separado.png" },
        { name: "Nubank", logo: "/img/account/Nubank.png" },
        { name: "PicPay", logo: "/img/account/PicPay.png" },
        { name: "Rico", logo: "/img/account/Rico.png" },
        { name: "Santander", logo: "/img/account/Santander.png" },
        { name: "Sicoob", logo: "/img/account/Sicoob.png" },
        { name: "Sodexo", logo: "/img/account/Sodexo.png" },
        { name: "XP Investimentos", logo: "/img/account/XP Investimentos.png" },
    ];

    function filterAccounts() {
        const input = document.getElementById('name').value.toLowerCase();
        const list = document.getElementById('account-list');
        list.innerHTML = '';

        if (input.length < 1) {
            list.classList.add('hidden');
            return;
        }

        const filteredAccounts = accounts.filter(account => account.name.toLowerCase().includes(input));

        if (filteredAccounts.length === 0) {
            list.classList.add('hidden');
            return;
        }

        filteredAccounts.forEach(account => {
            const listItem = document.createElement('li');
            listItem.className = 'flex items-center p-2 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600';
            listItem.innerHTML = `<img src="${account.logo}" alt="${account.name}" class="w-6 h-6 mr-2"><span>${account.name}</span>`;
            listItem.onclick = () => {
                document.getElementById('name').value = account.name;
                list.classList.add('hidden');
            };
            list.appendChild(listItem);
        });

        list.classList.remove('hidden');
    }
</script>
