<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                    Gerenciamento de Usuários
                </h2>
                <a href="" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Adicionar Novo Usuário
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="flex flex-col gap-4">
                @forelse ($users as $user)
                    <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg flex h-48 overflow-hidden gap-4">
                        <div class="w-48 h-full bg-gray-200 dark:bg-gray-700 flex-shrink-0 flex items-center justify-center">
                            @if($user->image)
                                <img src="{{ asset('storage/' . $user->image) }}" class="w-full h-full object-cover" alt="{{ $user->name }}">
                            @else
                                <span class="text-gray-500 dark:text-gray-300">Sem foto</span>
                            @endif
                        </div>

                        <div class="p-6 flex-1 flex flex-col justify-between text-gray-900 dark:text-gray-100">
                            <div>
                                <h3 class="text-xl font-semibold">
                                    {{ $user->name }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 mt-2">
                                    {{ $user->email }}
                                </p>
                            </div>
                            <div class="flex justify-between items-center mt-4">
                                <p class="px-3 py-1 text-sm font-semibold rounded-full {{ $user->function_id == 1 ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $user->function_id == 1 ? 'Administrador' : 'Usuário' }}
                                </p>
                                <div class="flex items-center gap-2">
                                    <a href="" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                                        Editar
                                    </a>
                                    <form action="" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <p class="text-gray-500 dark:text-gray-400 text-center">Nenhum usuário cadastrado.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>