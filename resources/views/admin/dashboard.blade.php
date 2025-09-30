<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Bem-vindo, {{ Auth::user()->name }}!</h3>

                    {{-- Verifica se o usuário é Admin ou Vendedor --}}
                    @if(Auth::user()->function_id == 1 || Auth::user()->function_id == 2)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">

                            <a href="{{ route('produtos.index') }}" class="block">
                                <div
                                    class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                                    <h4 class="text-2xl font-bold mb-2">Gerenciar Produtos</h4>
                                    <p>Adicione, edite ou remova produtos.</p>
                                </div>
                            </a>

                                <a href="{{ route('admin.users.index') }}" class="block">
                                    <div
                                        class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                                        <h4 class="text-2xl font-bold mb-2">Gerenciar Usuários</h4>
                                        <p>Gerencie os usuários do sistema.</p>
                                    </div>
                                </a>

                                <a href="{{ route('admin.email.create') }}" class="block">
                                    <div
                                        class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                                        <h4 class="text-2xl font-bold mb-2">Enviar Email</h4>
                                        <p>Envie emails para os usuários.</p>
                                    </div>
                                </a>
                            @endif

                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>