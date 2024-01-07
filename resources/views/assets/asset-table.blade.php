
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Ativo
                </th>
                <th scope="col" class="px-3 py-3">
                    Qtde.
                </th>
                <th scope="col" class="px-6 py-3">
                    Preço Médio
                </th>
                <th scope="col" class="px-6 py-3">
                    Preço Atual
                </th>
                <th scope="col" class="px-6 py-3">
                    Variação diária %
                </th>
                <th scope="col" class="px-6 py-3">
                    Variação diária $
                </th>
                <th scope="col" class="px-6 py-3">
                    Variação Total %
                </th>
                <th scope="col" class="px-6 py-3">
                    Variação Total $
                </th>
                <th scope="col" class="px-8 py-3">
                    Saldo
                </th>
                <th scope="col" class="px-6 py-3">
                    Ações
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assets as $key => $asset)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $asset->code }}
                    </th>
                    <td class="px-3 py-4">
                        {{ $asset->quantity }}
                    </td>
                    <td class="px-6 py-4">
                        R$ {{ $asset->average_price }}
                    </td>
                    <td class="px-6 py-4">
                        R$ {{ $processedData[$key]['current_price'] }}
                    </td>

                    @if ($processedData[$key]['daily_variation'] > 0)
                        <td class="px-6 py-4 text-green-500">
                    @else
                        <td class="px-6 py-4 text-red-500">
                    @endif
                        {{ $processedData[$key]['daily_variation'] }} %
                    </td>

                    @if ($processedData[$key]['daily_money_variation'] > 0)
                        <td class="px-6 py-4 text-green-500">
                    @else
                        <td class="px-6 py-4 text-red-500">
                    @endif
                        R$ {{ $processedData[$key]['daily_money_variation'] }}
                    </td>

                    @if ($processedData[$key]['total_percent_variation'] > 0)
                        <td class="px-6 py-4 text-green-500">
                    @else
                        <td class="px-6 py-4 text-red-500">
                    @endif
                        {{ $processedData[$key]['total_percent_variation'] }} %
                    </td>

                    @if ($processedData[$key]['total_money_variation'] > 0)
                        <td class="px-6 py-4 text-green-500">
                    @else
                        <td class="px-6 py-4 text-red-500">
                    @endif
                        R$ {{ $processedData[$key]['total_money_variation'] }}
                    </td>

                    <td class="px-2 py-4">
                        R$ {{ $processedData[$key]['patrimony'] }}
                    </td>
                    
                    <td class="px-4 py-4">
                        <a href="#"class="font-medium text-blue-600 dark:text-purple-500">See</a>
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
