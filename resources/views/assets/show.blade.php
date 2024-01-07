<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $asset->code }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('assets.index') }}">
                <button class="bg-purple-700 hover:bg-purple-500 text-white font-bold py-2 px-10 rounded">Voltar</button>
            </a>
            <br><br>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('assets.store') }}" method="POST">
                        @csrf
                        @include('asset.form')
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>