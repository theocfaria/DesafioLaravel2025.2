<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class HistoricoCompraController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $compras = Order::where('buyer_id', $user->user_id)->with(['seller', 'product.category'])->latest()->paginate(10);

        return view('historico-compras', compact('compras'));
    }
}
