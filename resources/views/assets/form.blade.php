<div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-white-700 text-xs font-bold mb-2" for="name">
            Asset Name
        </label>
        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="name" name="name" type="text" placeholder="Petrobras" value="{{$asset->name ?? ""}}">
    </div>
    <div class="w-full md:w-1/2 px-3">
        <label class="block uppercase tracking-wide text-white-700 text-xs font-bold mb-2" for="code">
            Asset Code
        </label>
        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="code" name="code" type="text" placeholder="PETR4" value="{{$asset->code ?? ""}}">
    </div>
</div>

<div class="flex flex-wrap -mx-3 mb-2">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-white-700 text-xs font-bold mb-2" for="quantity">
        Quantity
        </label>
        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="quantity" name="quantity" type="text" placeholder="0" value="{{$asset->quantity ?? ""}}">
    </div>
    
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-white-700 text-xs font-bold mb-2" for="average_price">
        Average Price
        </label>
        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="average_price" name="average_price" type="text" placeholder="R$ 00,00" value="{{$asset->average_price ?? ""}}">
    </div>

    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-white-700 text-xs font-bold mb-2" for="type">
        type
        </label>
        <div class="relative">
        <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="type" name="type" value="{{$asset->type ?? ""}}">
            <option value="stocks">Stocks</option>
            <option value="reit">Reit</option>
            <option value="crypto">Crypto</option>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
        </div>
    </div>
</div>
