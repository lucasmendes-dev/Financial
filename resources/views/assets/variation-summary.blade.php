<div class="mt-10 mb-3">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="w-full grid grid-cols-3 gap-4">
                    <!-- Caixa 1 (à esquerda) -->
                    <div class="bg-gray-700 rounded-lg p-4">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Variação Diária Total</h2>
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