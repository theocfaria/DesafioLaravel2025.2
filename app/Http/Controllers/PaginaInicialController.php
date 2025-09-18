<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PaginaInicialController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);

        return view('pagina-inicial', compact('products'));
    }
}
