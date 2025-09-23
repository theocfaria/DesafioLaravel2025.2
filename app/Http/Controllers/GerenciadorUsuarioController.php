<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Storage;

class GerenciadorUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.gerenciamento-usuario', compact('users'));
    }

    public function create() {
        return view('admin.criar-usuario');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:45'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:45', 'unique:'.User::class],
            'cpf' => ['required', 'string', 'max:14', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'birth' => ['required', 'date'],
            'phone_number' => ['required', 'string', 'max:16'],
            'function_id' => ['required', 'integer', Rule::in([1, 2])],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $data = $request->except('password', 'image');
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('users', 'public');
        }

        User::create($data);
        return redirect()->route('admin.users.index')
                         ->with('success', 'Usuário criado com sucesso!');
    }

    public function edit(User $user) {
        return view('admin.editar-usuario', compact('user'));
    }

     public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:45'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:45', Rule::unique('users')->ignore($user->user_id, 'user_id')],
            'cpf' => ['required', 'string', 'max:14', Rule::unique('users')->ignore($user->user_id, 'user_id')],
            'birth' => 'date',
            'phone_number' => ['required', 'string', 'max:16'],
            'function_id' => ['required', 'integer', Rule::in([1, 2])],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = $request->except('password', 'image');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $data['image'] = $request->file('image')->store('users', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        if ($user->user_id === auth()->id()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Você não pode excluir sua própria conta.');
        }

        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Usuário excluído com sucesso!');
    }

}