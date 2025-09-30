<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Histórico de Atividades') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Aqui você pode visualizar seu histórico de compras e seu histórico de vendas.') }}
        </p>
    </header>

    <div class="flex items-center gap-4">
        <a href="{{ route('historico-compras.index') }}">
            <x-secondary-button>
                {{ __('Ver Histórico de Compras') }}
            </x-secondary-button>
        </a>

        @if(Auth::user()->function_id == 1 || Auth::user()->function_id == 2)
            <a href="{{ route('historico-vendas.index') }}">
                <x-primary-button>
                    {{ __('Ver Histórico de Vendas') }}
                </x-primary-button>
            </a>
        @endif
    </div>
</section>