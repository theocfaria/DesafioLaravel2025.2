<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg overflow-hidden md:flex flex-grow">
                <div class="md:w-1/2 p-6 flex-shrink-0 flex items-center justify-center">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="w-full h-96 object-contain rounded-lg shadow-md">
                    @else
                        <div
                            class="w-full h-96 bg-gray-200 dark:bg-gray-700 flex items-center justify-center rounded-lg shadow-md">
                            <span class="text-gray-500 dark:text-gray-300">Sem imagem</span>
                        </div>
                    @endif
                </div>

                <div class="md:w-1/2 p-6 flex flex-col justify-between text-gray-900 dark:text-gray-100">
                    <div>
                        <h1 class="text-4xl font-bold mb-2">{{ $product->name }}</h1>
                        <p class="text-gray-500 dark:text-gray-300 text-sm mb-4">
                            Categoria: <span class="font-semibold">{{ $product->category->category_name }}</span>
                        </p>

                        <p class="text-gray-700 dark:text-gray-200 leading-relaxed mb-6">{{ $product->description }}</p>

                        <div class="flex items-baseline justify-between mb-6">
                            <p class="text-4xl font-extrabold text-blue-600">R$
                                {{ number_format($product->price, 2, ',', '.') }}
                            </p>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Disponível: <span class="font-semibold">{{ $product->quantity }}</span> unidades
                            </p>
                        </div>

                        <hr class="my-4">

                        <div class="mb-6">
                            <h2 class="text-xl font-semibold mb-2">Anunciado por: {{ $product->seller->name }}</h2>
                        </div>
                    </div>

                    <div>
                        @auth
                            @if (Auth::user()->is_admin)
                                <p class="text-center text-red-500 font-semibold text-lg">Como administrador, você não pode
                                    comprar produtos.</p>

                            @elseif (Auth::id() === $product->seller_id)
                                <p class="text-center text-yellow-500 font-semibold text-lg">Você não pode comprar seu próprio
                                    produto.</p>

                            @else
                                <form action="/checkout" method="POST">
                                    @csrf

                                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">

                                    <div class="flex items-center justify-center gap-4 mb-4">
                                        <label for="quantity" class="font-semibold">Quantidade:</label>
                                        <input type="number" id="quantity" name="product_quantity" value="1" min="1"
                                            max="{{ $product->quantity }}"
                                            class="w-20 text-center bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                            required>
                                    </div>
                                    @if ($errors->any())
                                        <div class="mb-4 rounded-lg bg-red-100 p-4 text-sm text-red-700 dark:bg-red-200 dark:text-red-800"
                                            role="alert">
                                            <span class="font-bold">Ocorreram alguns erros:</span>
                                            <ul class="mt-2 list-inside list-disc">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if(session('error'))
                                        <div class="mb-4 rounded-lg bg-red-100 p-4 text-sm text-red-700 dark:bg-red-200 dark:text-red-800"
                                            role="alert">
                                            <span class="font-bold">{{ session('error') }}</span>
                                        </div>
                                    @endif
                                    <button type="submit"
                                        class="w-full bg-blue-600 text-white font-bold py-3 px-6 rounded-full text-lg text-center hover:bg-blue-700 transition-colors duration-300 shadow-lg">
                                        Comprar
                                    </button>
                                </form>
                            @endif
                        @endauth

                        @guest
                            <div class="text-center">
                                <p class="text-gray-500 dark:text-gray-300 mb-2">Para comprar, por favor, faça login.</p>
                                <a href="{{ route('login') }}"
                                    class="w-full inline-block bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 font-bold py-3 px-6 rounded-full text-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-300">
                                    Fazer Login
                                </a>
                            </div>
                        @endguest

                        @if(session('error'))
                            <p class="text-red-500 text-center mt-4">{{ session('error') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>