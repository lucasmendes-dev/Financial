
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Asset
                </th>
                <th scope="col" class="px-6 py-3">
                    Qty.
                </th>
                <th scope="col" class="px-6 py-3">
                    Average Price
                </th>
                <th scope="col" class="px-6 py-3">
                    Current Price
                </th>
                <th scope="col" class="px-6 py-3">
                    Daily Variation %
                </th>
                <th scope="col" class="px-6 py-3">
                    Daily Variation $
                </th>
                <th scope="col" class="px-6 py-3">
                    Total variation %
                </th>
                <th scope="col" class="px-6 py-3">
                    Total variation $
                </th>
                <th scope="col" class="px-6 py-3">
                    Total Amount
                </th>
                <th scope="col" class="px-6 py-3">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assets as $key => $asset)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $asset->code }}
                    </th>
                    <td class="px-6 py-4">
                        
                    </td>
                    <td class="px-6 py-4">
                        0
                    </td>
                    <td class="px-6 py-4">
                        {{ $api[$key]['price'] }}
                    </td>
                    <td class="px-6 py-4 text-green-500">
                        0
                    </td>
                    <td class="px-6 py-4 text-green-500">
                        0
                    </td>
                    <td class="px-6 py-4 text-green-500">
                        0
                    </td>
                    <td class="px-6 py-4 text-green-500">
                        0
                    </td>
                    <td class="px-4 py-4">
                        0
                    </td>
                    <td class="px-6 py-4">
                        <a href="#"class="font-medium text-blue-600 dark:text-purple-500">See</a>
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
