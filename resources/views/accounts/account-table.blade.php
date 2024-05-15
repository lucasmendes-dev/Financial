<div class="relative overflow-x-auto shadow-md sm:rounded-lg">

    <div class="flex justify-between mb-2">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-3">Contas</h1>
        <p class="font-semibold text-gray-800 dark:text-gray-200 leading-tight ml-4">Total: R$  {{ number_format($acconts_sum, 2, ',', '.') }}</p>
    </div>

    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-5 py-3">
                    <div class="flex items-center">
                        
                    </div>
                </th>
                <th scope="col" class="px-5 py-3">
                    <div class="flex items-center">
                        Conta
                    </div>
                </th>
                <th scope="col" class="px-5 py-3">
                    <div class="flex items-center">
                        Saldo
                    </div>
                </th>

                <th scope="col" class="px-6 py-3 text-center">-</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($accounts as $key => $account)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                    <td class="px-4 py-4">
                       <img src="/account/{{ $account->name }}.png" width="35px" alt="">
                    </td>

                    <th scope="row" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $account->name }}
                    </th>

                    <td class="px-4 py-4">
                        R$ {{ number_format($account->balance, 2, ',', '.') }} 
                    </td>

                    <td class="px-4 py-4 text-center">

                        <a href="{{ route('accounts.edit', $account->id) }}" class="dark:text-blue-500 hover:underline mx-2">
                            <ion-icon name="create-outline" class="w-4 h-4"></ion-icon>
                        </a>

                        <button data-record-id="{{ $account->id }}" class="dark:text-red-500 hover:underline delete-button" type="button">
                            <ion-icon name="trash-outline" class="w-4 h-4"></ion-icon>
                        </button>
                        
                    </td>

                </tr>

            @endforeach
        </tbody>
    </table>
</div>