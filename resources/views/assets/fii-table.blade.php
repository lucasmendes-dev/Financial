<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div class="flex justify-between mb-2">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Fundo Imobiliário</h1>
        <p class="font-semibold text-gray-800 dark:text-gray-200 leading-tight ml-4">Total: R$ {{ number_format($sum['reitSum'], 2, ',', '.') }}</p>
    </div>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-5 py-3">
                    <div class="flex items-center">
                        Código
                    </div>
                </th>
                <th scope="col" class="px-5 py-3">
                    <div class="flex items-center">
                        Qte.
                    </div>
                </th>
                <th scope="col" class="px-5 py-3">
                    <div class="flex items-center">
                        Preço Médio
                    </div>
                </th>
                <th scope="col" class="px-5 py-3">
                    <div class="flex items-center">
                        Preço Atual
                    </div>
                </th>
                <th scope="col" class="px-5 py-3">
                    <div class="flex items-center">
                        Variação diária
                    </div>
                </th>
                <th scope="col" class="px-5 py-3">
                    <div class="flex items-center">
                        Variação diária
                    </div>
                </th>
                <th scope="col" class="px-5 py-3">
                    <div class="flex items-center">
                        Variação Total
                    </div>
                </th>
                <th scope="col" class="px-5 py-3">
                    <div class="flex items-center">
                        Variação Total
                    </div>
                </th>
                <th scope="col" class="px-5 py-3">
                    <div class="flex items-center">
                        Valor Total
                    </div>
                </th>
                <th scope="col" class="px-5 py-3">Ações</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($assets as $key => $asset)
                @if ($asset->type == 'reit')
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                    <th scope="row" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $asset->code }}
                    </th>

                    <td class="px-4 py-4">
                        {{ $asset->quantity }}
                    </td>

                    <td class="px-4 py-4">
                        R$ {{ $asset->average_price }}
                    </td>

                    <td class="px-4 py-4">
                        R$ {{ $processedData[$key]['current_price'] }}
                    </td>

                    @if ($processedData[$key]['daily_variation'] > 0)
                        <td class="px-4 py-4 text-green-500">
                    @else
                        <td class="px-4 py-4 text-red-500">
                    @endif
                        {{ $processedData[$key]['daily_variation'] }} %
                    </td>

                    @if ($processedData[$key]['daily_money_variation'] > 0)
                        <td class="px-4 py-4 text-green-500">
                    @else
                        <td class="px-4 py-4 text-red-500">
                    @endif
                        R$ {{ $processedData[$key]['daily_money_variation'] }}
                    </td>

                    @if ($processedData[$key]['total_percent_variation'] > 0)
                        <td class="px-4 py-4 text-green-500">
                    @else
                        <td class="px-4 py-4 text-red-500">
                    @endif
                        {{ $processedData[$key]['total_percent_variation'] }}%
                    </td>

                    @if ($processedData[$key]['total_money_variation'] > 0)
                        <td class="px-4 py-4 text-green-500">
                    @else
                        <td class="px-4 py-4 text-red-500">
                    @endif
                        R$ {{ $processedData[$key]['total_money_variation'] }}
                    </td>

                    <td class="px-4 py-4">
                        R$ {{ $processedData[$key]['patrimony'] }}
                    </td>
                    <td class="px-4 py-4 text-right">

                        <a href="{{ route('assets.edit', $asset->id) }}" class="dark:text-blue-500 hover:underline mx-2">
                            <ion-icon name="create-outline" class="w-4 h-4"></ion-icon>
                        </a>

                        <button data-record-id="{{ $asset->id }}" class="dark:text-red-500 hover:underline delete-button" type="button">
                            <ion-icon name="trash-outline" class="w-4 h-4"></ion-icon>
                        </button>
                        
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>