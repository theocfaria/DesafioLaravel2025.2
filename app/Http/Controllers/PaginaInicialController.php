<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class PaginaInicialController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $selectedCategory = $request->category ?? '';
        $searchTerm = $request->q ?? '';

        $query = Product::with(['seller', 'category'])->orderBy('created_at', 'desc');

        if ($searchTerm !== '') {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        if ($selectedCategory !== '') {
            $query->where('category_id', $selectedCategory);
        }

        $products = $query->paginate(10)->withQueryString();

        return view('pagina-inicial', compact('products', 'categories', 'selectedCategory', 'searchTerm'));
    }
}

