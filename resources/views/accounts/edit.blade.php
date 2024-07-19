<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-10 text-gray-900 dark:text-gray-100">

                    <a href="{{ route('accounts.index')}}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">voltar</a>

                    <div class=" inset-0 flex items-center justify-center z-50">
                        <div class="px-6 py-6 lg:px-8">
                            <div class="flex items-center justify-between">
                                <h3 class="mb-6 text-xl font-medium text-gray-900 dark:text-white">Editar - {{ $account->name }}</h3>
                                <img src="/img/account/{{ $account->name }}.png" width="15%" alt="logo">
                            </div>
                            <form class="space-y-6" action="{{ route('accounts.update', $account->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div>
                                    <div>
                                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome da Conta</label>
                                        <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="PETR4" required" value="{{ $account->name }}">
                                    </div>
                                </div>
                
                                <div class="flex space-x-4">
                                    <div class="w-1/2">
                                        <label for="balance" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Saldo</label>
                                        <input type="number" step="0.01" name="balance" id="balance" placeholder="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required value="{{ $account->balance }}">
                                    </div>
                                    <div class="w-1/2">
                                        <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo</label>
                                        <select name="type" id="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="{{ $account->type }}">
                                            <option value="current" @if($account->type == 'current') selected @endif>Corrente</option>
                                            <option value="savings" @if($account->type == 'savings') selected @endif>Poupança</option>
                                            <option value="broker" @if($account->type == 'broker') selected @endif>Corretora</option>
                                            <option value="ticket" @if($account->type == 'ticket') selected @endif>Ticket</option>
                                            <option value="crypto" @if($account->type == 'crypto') selected @endif>Crypto</option>
                                        </select>
                                    </div>
                                </div>
                        
                                <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Alterar</button>
                        
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
