<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ativos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <br> <br>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="text-center mt-8">
                        <p class="text-lg text-gray-600 dark:text-gray-300">Você atualizou seus dados!</p>
                        <br>
                        <a href="{{ route('assets.index') }}">
                            <button class="bg-purple-700 hover:bg-purple-500 text-white font-bold py-2 px-10 rounded">Clique para voltar</button>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
