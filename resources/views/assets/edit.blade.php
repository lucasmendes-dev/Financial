<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <p>Edit {{ $asset->code }}</p>
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('assets.index') }}">
                <button class="bg-purple-700 hover:bg-purple-500 text-white font-bold py-2 px-10 rounded">Back</button>
            </a>
            <br><br>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('assets.update', $asset->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('asset.form')
                        <br>
                        <button class="bg-purple-700 hover:bg-purple-500 text-white font-bold py-2 px-10 rounded" type="submit">Change</button>
                    </form>
                    <form action="{{ route('assets.destroy', $asset->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-700 hover:bg-red-500 text-white font-bold py-2 px-10 rounded" type="submit">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>