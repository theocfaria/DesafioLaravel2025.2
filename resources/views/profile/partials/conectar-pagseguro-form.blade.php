<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Conexão com PagSeguro') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Conecte sua conta PagSeguro para que os valores de suas vendas sejam creditados diretamente para você.') }}
        </p>
    </header>

    <div class="mt-6">
        @if (Auth::user()->pagseguro_authorization_code)
            <div class="flex items-center gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Sua conta PagSeguro está conectada com sucesso!') }}
                </p>
            </div>
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                {{ __('Nenhuma ação adicional é necessária. Você já pode receber pagamentos por seus produtos anunciados.') }}
            </p>
        @else
             <a href="{{ route('pagseguro.connect') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Conectar com PagSeguro') }}
            </a>
        @endif
    </div>
</section>