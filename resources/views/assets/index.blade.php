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
                            <div class="max-w-7xl  sm:px-6 lg:px-8 flex justify-between items-center">
            
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
                            <div class="max-w-7xl  sm:px-6 lg:px-8 flex justify-between items-center">
            
                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg accountTable"> 
                                    <div class="p-6 text-gray-900 dark:text-gray-100">
                                        @include('assets.fii-graph')
                                    </div>
                                </div>
                                
                                <canvas id="reitChart" class="chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</x-app-layout>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    
    // Stock Chart
    const stock_ctx = document.getElementById('stockChart').getContext('2d');

    //data from laravel controller
    const stockNames = @json($stockNames);
    const stockPercentages = @json($stockPercentages);

    new Chart(stock_ctx, {
        type: 'doughnut',
        data: {
            labels: stockNames,
            datasets: [{
                label: 'Porcentagem',
                data: stockPercentages,
                borderWidth: 1,
                // backgroundColor: [
                //     'rgb(255, 238, 0)',
                //     'rgb(255, 0, 170)',
                //     'rgba(0, 153, 204, 1)',
                //     'rgba(0, 128, 0, 1)',
                //     'rgba(153, 153, 153, 1)',
                //     'rgba(25, 25, 25)',
                // ],
                hoverOffset: 10
            }]
        },
        options: {}
    });

    // Reit Chart
    const reit_ctx = document.getElementById('reitChart').getContext('2d');

    //data from laravel controller
    const reitNames = @json($reitNames);
    const reitPercentages = @json($reitPercentages);

    new Chart(reit_ctx, {
        type: 'doughnut',
        data: {
            labels: reitNames,
            datasets: [{
                label: 'Porcentagem',
                data: reitPercentages,
                borderWidth: 1,
                // backgroundColor: [
                //     'rgb(255, 238, 0)',
                //     'rgb(255, 0, 170)',
                //     'rgba(0, 153, 204, 1)',
                //     'rgba(0, 128, 0, 1)',
                //     'rgba(153, 153, 153, 1)',
                //     'rgba(25, 25, 25)',
                // ],
                hoverOffset: 10
            }]
        },
        options: {}
    });
</script>