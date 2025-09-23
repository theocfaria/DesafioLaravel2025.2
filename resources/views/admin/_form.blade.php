@if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <p class="font-bold">Opa! Algo deu errado.</p>
        <ul class="mt-2 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="w-1/1 dark:bg-gray-800 shadow-xl sm:rounded-lg overflow-hidden md:flex flex-grow">

    <div class="md:w-1/2 p-6 flex-shrink-0 flex flex-col items-center justify-center gap-4">
        <h3 class="block text-lg font-semibold text-gray-700 dark:text-gray-300 self-start">Foto de Perfil & Acesso</h3>

        @if(isset($user) && $user->image)
            <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="w-full h-96 object-contain rounded-lg shadow-md">
        @else
            <div class="w-full h-96 bg-gray-200 dark:bg-gray-700 flex items-center justify-center rounded-lg shadow-md">
                <span class="text-gray-500 dark:text-gray-300">Sem foto de perfil</span>
            </div>
        @endif

        <div>
            <input type="file" name="image" id="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            @error('image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="w-full space-y-4 pt-4">
            {{-- Senha --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Senha</label>
                <input type="password" name="password" id="password" autocomplete="new-password" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100">
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Deixe em branco para não alterar.</p>
                @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirmar Senha</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100">
            </div>
            <div>
                 <label for="function_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Função do Usuário</label>
                <select name="function_id" id="function_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100">
                    <option value="2" @selected(old('function_id', $user->function_id ?? '2') == 2)>Usuário</option>
                    <option value="1" @selected(old('function_id', $user->function_id ?? '2') == 1)>Administrador</option>
                </select>
            </div>
        </div>
    </div>

    <div class="md:w-1/2 p-6 flex flex-col text-gray-900 dark:text-gray-100">

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome Completo</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm text-2xl font-bold dark:bg-gray-700 dark:text-gray-100" required>
            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100" required>
            @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label for="cpf" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CPF</label>
                <input type="text" name="cpf" id="cpf" value="{{ old('cpf', $user->cpf ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100" required>
                @error('cpf') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="birth" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nascimento</label>
                <input type="date" name="birth" id="birth" 
                    value="{{ old('birth', optional($user->birth ?? null)->format('Y-m-d')) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100" required>
                @error('birth') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
             <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telefone</label>
                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100" required>
                @error('phone_number') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="cep" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CEP</label>
                    <input type="text" name="cep" id="cep" value="{{ old('cep', $user->cep ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100">
                </div>
                 <div class="col-span-2">
                    <label for="street" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rua</label>
                    <input type="text" name="street" id="street" value="{{ old('street', $user->street ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número</label>
                    <input type="text" name="number" id="number" value="{{ old('number', $user->number ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100">
                </div>
                <div class="col-span-2">
                    <label for="district" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bairro</label>
                    <input type="text" name="district" id="district" value="{{ old('district', $user->district ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100">
                </div>
            </div>
             <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="col-span-2">
                    <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cidade</label>
                    <input type="text" name="city" id="city" value="{{ old('city', $user->city ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100">
                </div>
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                    <input type="text" name="state" id="state" value="{{ old('state', $user->state ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100">
                </div>
            </div>
        </div>

        <div class="mt-auto flex items-center justify-end gap-4 pt-6">
            <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                Cancelar
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ isset($user) && $user->exists ? 'Salvar Alterações' : 'Salvar Usuário' }}
            </button>
        </div>
    </div>
    <script src="{{ asset('/cep.js') }}"></script>

</div>