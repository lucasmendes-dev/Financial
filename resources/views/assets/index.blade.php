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

    @if (!empty($reit->all()))
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

@include('assets.delete-modal')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    // Stock Chart
    const stock_ctx = document.getElementById('stockChart');
    if (stock_ctx) {
        stock_ctx.getContext('2d');

        //data from laravel controller
        const stockNames = @json($stockNames);
        const stockPercentages = @json($stockPercentages);

        new Chart(stock_ctx, {
            type: 'doughnut',
            data: {
                labels: stockNames,
                datasets: [{
                    data: stockPercentages,
                    borderWidth: 2,
                    borderColor: '#1f2937',
                    backgroundColor: [
                        'rgb(255, 238, 45)',
                        'rgb(0, 74, 143)',
                        'rgb(240, 243, 250)',
                        'rgb(0, 242, 58)',
                        'rgb(0, 147, 154)',
                        'rgb(245, 108, 0)',
                        'rgb(255, 238, 45)',
                        'rgb(64, 164, 113)',
                        'rgb(37, 128, 74)',
                        'rgb(206, 32, 61)',
                    ],
                    hoverOffset: 20
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed;
                                return `${value.toFixed(2)}%`; // displays number with '.' and % at the end
                            }
                        }
                    }
                }
            }
        });
    }

    // Reit Chart
    const reit_ctx = document.getElementById('reitChart');
    if (reit_ctx) {
        reit_ctx.getContext('2d');
    
        //data from laravel controller
        const reitNames = @json($reitNames);
        const reitPercentages = @json($reitPercentages);

        new Chart(reit_ctx, {
            type: 'doughnut',
            data: {
                labels: reitNames,
                datasets: [{
                    data: reitPercentages,
                    borderWidth: 2,
                    borderColor: '#1f2937',
                    backgroundColor: [
                        'rgb(255, 238, 45)',
                        'rgb(0, 74, 143)',
                        'rgb(240, 243, 250)',
                        'rgb(0, 242, 58)',
                        'rgb(0, 147, 154)',
                        'rgb(245, 108, 0)',
                        'rgb(255, 238, 45)',
                        'rgb(64, 164, 113)',
                        'rgb(37, 128, 74)',
                        'rgb(206, 32, 61)',
                    ],
                    hoverOffset: 20
                }]
            },
            options: {
                // displays number with '.' and % at the end
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed;
                                return `${value.toFixed(2)}%`;
                            }
                        }
                    }
                }
            }
        });
    }
</script>
