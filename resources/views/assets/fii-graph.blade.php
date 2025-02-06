<div class="relative overflow-x-auto shadow-md sm:rounded-lg">

    <div class="flex justify-between mb-2">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-3">Fundo Imobiliário</h1>
    </div>

    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-5 py-3">
                    <div class="flex items-center">
                        
                    </div>
                </th>
                <th scope="col" class="px-5 py-3">
                    <div class="flex items-center">
                        Ativo
                    </div>
                </th>
                <th scope="col" class="px-5 py-3">
                    <div class="flex items-center">
                        Variação Hoje
                    </div>
                </th>

                <th scope="col" class="px-6 py-3 text-center">Ações</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($assets as $key => $asset)
                @if ($asset->type == 'reit')
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">

                    <td class="px-4 py-4">
                       
                       <img src="{{ $processedData[$key]['logo_url'] }}" alt="logo" width=40px">
                    </td>

                    <th scope="row" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $asset->code }}
                    </th>


                    @if ($processedData[$key]['daily_variation'] > 0)
                        <td class="px-4 py-4 text-green-500 text-center">
                    @elseif ($processedData[$key]['daily_variation'] == 0)
                        <td class="px-4 py-4 text-gray-400 text-center">
                    @else
                        <td class="px-4 py-4 text-red-500 text-center">
                    @endif
                        {{ number_format($processedData[$key]['daily_variation'], 2, '.', '.') }}%
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