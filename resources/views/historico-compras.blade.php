<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                    Histórico de Compras
                </h2>
            </div>

            <div class="mb-6 p-4 bg-white dark:bg-gray-800 shadow-md sm:rounded-lg">
                <div class="md:flex md:items-end md:justify-between">
                    <form action="{{ route('historico-compras.index') }}" method="GET"
                        class="flex items-end space-x-4 gap-2">
                        <div>
                            <label for="start_date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data Início</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-700 dark:text-gray-300">
                        </div>
                        <div>
                            <label for="end_date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data Fim</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-700 dark:text-gray-300">
                        </div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Filtrar
                        </button>
                    </form>

                    <form action="{{ route('historico-compras.pdf') }}" method="GET" target="_blank"
                        class="mt-4 md:mt-0 items-center">
                        <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                        <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Gerar PDF
                        </button>
                    </form>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                @forelse ($compras as $compra)
                    <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg flex h-40 overflow-hidden gap-4">
                        <div
                            class="w-40 h-full bg-gray-200 dark:bg-gray-700 flex-shrink-0 flex items-center justify-center">
                            @if($compra->product->image)
                                <img src="{{ asset('storage/' . $compra->product->image) }}" class="w-full h-full object-cover"
                                    alt="{{ $compra->product->name }}">
                            @else
                                <span class="text-gray-500 dark:text-gray-300">Sem Imagem</span>
                            @endif
                        </div>

                        <div class="p-4 sm:p-6 flex-1 flex flex-col justify-between text-gray-900 dark:text-gray-100">
                            <div>
                                <h3 class="text-xl font-semibold">{{ $compra->product->name }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                    Vendido por: <span class="font-medium">{{ $compra->seller->name }}</span>
                                </p>
                            </div>
                            <div class="flex justify-between items-center mt-3">
                                <p class="text-blue-600 dark:text-blue-400 font-bold text-lg">
                                    R$ {{ number_format($compra->total_amount, 2, ',', '.') }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $compra->created_at->format('d/m/Y \à\s H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <p class="text-gray-500 dark:text-gray-400 text-center">Nenhuma compra encontrada.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $compras->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
