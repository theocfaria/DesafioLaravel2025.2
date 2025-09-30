<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST"
                action="{{ route('produtos.update', ['product_id' => $product->product_id, 'seller_id' => $product->seller_id, 'category_id' => $product->category_id]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg overflow-hidden md:flex flex-grow"
                     x-data="{ imageUrl: '{{ $product->image ? asset('storage/' . $product->image) : '' }}' }">

                    <div class="md:w-1/2 p-6 flex-shrink-0 flex flex-col items-center justify-center gap-4">
                        <label for="image"
                            class="block text-lg font-semibold text-gray-700 dark:text-gray-300 self-start">Imagem do
                            Produto</label>

                        <template x-if="imageUrl">
                            <img :src="imageUrl" alt="Preview da Imagem"
                                 class="w-full h-96 object-contain rounded-lg shadow-md">
                        </template>
                        <template x-if="!imageUrl">
                            <div
                                class="w-full h-96 bg-gray-200 dark:bg-gray-700 flex items-center justify-center rounded-lg shadow-md">
                                <span class="text-gray-500 dark:text-gray-300">Sem imagem</span>
                            </div>
                        </template>

                        <div>
                            <input type="file" name="image" id="image"
                                   @change="imageUrl = URL.createObjectURL($event.target.files[0])"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        @error('image')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:w-1/2 p-6 flex flex-col text-gray-900 dark:text-gray-100">
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome do
                                Produto</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm text-2xl font-bold dark:bg-gray-700 dark:text-gray-100"
                                required>
                            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="category_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoria</label>
                            <select name="category_id" id="category_id"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100"
                                required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}" {{ $category->category_id == old('category_id', $product->category_id) ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
                            <textarea name="description" id="description" rows="5"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100"
                                required>{{ old('description', $product->description) }}</textarea>
                            @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="price"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Preço
                                    (R$)</label>
                                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}"
                                    step="0.01"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100"
                                    required>
                                @error('price') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="quantity"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantidade</label>
                                <input type="number" name="quantity" id="quantity"
                                    value="{{ old('quantity', $product->quantity) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100"
                                    required>
                                @error('quantity') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mt-auto flex items-center justify-end gap-4 pt-4">
                            <a href="{{ route('produtos.index') }}"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Salvar Alterações
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>