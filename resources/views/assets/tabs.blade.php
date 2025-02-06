<div class="max-w-5xl mx-auto sm:px-6 lg:px-8 mb-3">
    <ul class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow-sm sm:flex dark:divide-gray-700 dark:text-gray-400">
        <li class="w-full focus-within:z-10">
            @php
                $isActive = request()->routeIs('assets.index');
            @endphp
            <a href="{{ route('assets.index') }}"
                class="inline-block w-full p-4 bg-gray-100 border-r border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 focus:outline-none
                {{ $isActive ? 'text-gray-900 bg-gray-100 border-r dark:bg-gray-700 dark:text-white' : 'bg-white border-s-0 hover:text-gray-700 hover:bg-gray-50 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700' }}"
                aria-current="page">
                    Visão Geral
            </a>
        </li>

        <li class="w-full focus-within:z-10">
            <a href="{{ route('assets.detailedView') }}"
                class="inline-block w-full p-4 bg-gray-100 border-s-0 border-gray-200 dark:border-gray-700 rounded-e-lg focus:ring-4 focus:ring-blue-300 focus:outline-none
                {{ $isActive ? 'bg-white border-s-0 hover:text-gray-700 hover:bg-gray-50 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700' : 'text-gray-900 bg-gray-100 border-r dark:bg-gray-700 dark:text-white' }}"
                aria-current="page">
                    Visão Detalhada
            </a>
        </li>
    </ul>
</div>
