<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('pagina-inicial') }}" class="mb-6 flex flex-wrap gap-4 items-end">
                <div>
                    <label for="q" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Buscar</label>
                    <input type="text" name="q" id="q" value="{{ $searchTerm }}"
                        class="mt-1 block w-64 rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:text-gray-100">
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoria</label>
                    <select name="category" id="category"
                        class="mt-1 block w-48 rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:text-gray-100">
                        <option value="" {{ $selectedCategory === '' ? 'selected' : '' }}>Todas</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                        Filtrar
                    </button>
                    @if($searchTerm || $selectedCategory)
                        <a href="{{ route('pagina-inicial') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-black dark:text-white uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500">
                            Limpar
                        </a>
                    @endif
                </div>
            </form>

            <div class="flex flex-col gap-4">
                @foreach ($products as $product)
                    <a href="{{ route('produtos.show', ['product_id' => $product->product_id, 'seller_id' => $product->seller_id, 'category_id' => $product->category_id]) }}" class="block">
                        <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg flex h-48 overflow-hidden gap-4">
                            <div class="w-48 h-full bg-gray-200 dark:bg-gray-700 flex-shrink-0 flex items-center justify-center">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                                @else
                                    <span class="text-gray-500 dark:text-gray-300">Sem imagem</span>
                                @endif
                            </div>

                            <div class="p-6 flex-1 flex flex-col justify-between text-gray-900 dark:text-gray-100">
                                <div>
                                    <h3 class="text-xl font-semibold">
                                        {{ $product->name }}
                                    </h3>

                                    <p class="text-gray-600 dark:text-gray-300 mt-2">
                                        {{ Str::limit($product->description, 120) }}
                                    </p>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-blue-600 font-bold mt-4 text-lg">R$
                                        {{ number_format($product->price, 2, ',', '.') }}
                                    </p>
                                    <p class="text-gray-500">
                                        Vendedor: {{ Str::limit($product->seller->name, 120) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
