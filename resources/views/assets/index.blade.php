<x-app-layout>

    @include('assets.variation-summary');

    @include('assets.tabs');

    @if (!empty($stocks->all()))
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="max-w-7xl  sm:px-6 lg:px-8 flex justify-between">
            
                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg accountTable"> 
                                    <div class="p-6 text-gray-900 dark:text-gray-100">
                                        @include('assets.stock-graph')
                                    </div>
                                </div>
                                
                                <canvas id="stockChart" class="chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <br>

    @if (!empty($stocks->all()))
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="max-w-7xl  sm:px-6 lg:px-8 flex justify-between">
            
                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg accountTable"> 
                                    <div class="p-6 text-gray-900 dark:text-gray-100">
                                        @include('assets.fii-graph')
                                        <div class="flex items-center justify-end">
                                            {{-- <button data-modal-target="form-modal" data-modal-toggle="form-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-5 mr-4" type="button">
                                                Cadastrar Ativo
                                            </button> --}}
                                        </div>
                                    </div>
                                </div>
                                
                                <canvas id="accountChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- <div class="flex items-center justify-end">
        <button data-modal-target="form-modal" data-modal-toggle="form-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-5 mr-4" type="button">
            Cadastrar Ativo
        </button>
    </div> --}}
</x-app-layout>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    
    // Stock Chart
    const ctx = document.getElementById('stockChart').getContext('2d');

    //data from laravel controller
    const stockNames = @json($stockNames);
    const stockBalances = @json($stockBalances);

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: stockNames,
            datasets: [{
                label: 'Saldo',
                data: stockBalances,
                borderWidth: 1,
                backgroundColor: [
                    'rgb(255, 238, 0)',
                    'rgb(255, 0, 170)',
                    'rgba(0, 153, 204, 1)',
                    'rgba(0, 128, 0, 1)',
                    'rgba(153, 153, 153, 1)',
                    'rgba(25, 25, 25)',
                ],
                hoverOffset: 10
            }]
        },
        options: {}
    });
</script>