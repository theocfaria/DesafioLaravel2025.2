<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4">
                @foreach ($products as $product)
                    <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg flex h-48 overflow-hidden gap-4">
                        <div
                            class="w-48 h-full bg-gray-200 dark:bg-gray-700 flex-shrink-0 flex items-center justify-center">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover"
                                    alt="{{ $product->name }}">
                            @else
                                <span class="text-gray-500 dark:text-gray-300">Sem imagem</span>
                            @endif
                        </div>

                        <div class="p-6 flex-1 flex flex-col justify-between text-gray-900 dark:text-gray-100">
                            <div>
                                <h3 class="text-xl font-semibold">{{ $product->name }}</h3>
                                <p class="text-gray-600 dark:text-gray-300 mt-2">
                                    {{ Str::limit($product->description, 120) }}
                                </p>
                            </div>
                            <p class="text-blue-600 font-bold mt-4 text-lg">R$
                                {{ number_format($product->price, 2, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>

</x-app-layout>