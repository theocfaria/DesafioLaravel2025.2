<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Enviar E-mail para Usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($errors->any())
                        <div class="p-6 bg-red-100 border border-red-400 text-red-700 mb-4">
                            <div class="font-medium text-red-600 dark:text-red-400">{{ __('Opa! Algo deu errado.') }}</div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600 dark:text-red-400">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-4 font-medium text-sm text-red-600 dark:text-red-400">
                            {{ session('error') }}
                        </div>
                    @endif


                    <form action="{{ route('admin.email.send') }}" method="POST">
                        @csrf
                        <div class="mt-4">
                            <label for="user_id"
                                class="block font-medium text-sm text-gray-700 dark:text-gray-300">Selecione o
                                Usuário</label>
                            <select name="user_id" id="user_id"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required>
                                <option value=""> Selecione um usuário </option>
                                @foreach($users as $user)
                                    <option value="{{ $user->user_id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="assunto"
                                class="block font-medium text-sm text-gray-700 dark:text-gray-300">Assunto</label>
                            <input type="text" name="assunto" id="assunto"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required>
                        </div>

                        <div class="mt-4">
                            <label for="mensagem"
                                class="block font-medium text-sm text-gray-700 dark:text-gray-300">Conteúdo do
                                E-mail</label>
                            <textarea name="mensagem" id="mensagem" rows="10"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required></textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Enviar E-mail
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>