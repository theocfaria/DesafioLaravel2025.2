<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
}