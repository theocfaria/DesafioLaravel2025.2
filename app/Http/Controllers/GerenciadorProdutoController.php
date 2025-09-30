<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class GerenciadorProdutoController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->function_id == 1) {
            $products = Product::all();
        } else {
            $products = Product::where('seller_id', $user->user_id)->get();
        }

        $chart_options = [
            'chart_title' => 'Produtos cadastrados por mês',
            'model' => Product::class,
            'chart_type' => 'bar',
            'report_type' => 'group_by_date',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_color' => '37, 99, 235',
        ];

        $chart = new LaravelChart($chart_options);

        return view('gerenciamento-produto', compact('products', 'chart'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('criar-produto', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0.01',
            'quantity' => 'required|integer|min:0',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,category_id',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $lastProductId = Product::max('product_id');
        $nextProductId = $lastProductId ? $lastProductId + 1 : 1;

        Product::create([
            'product_id' => $nextProductId,
            'seller_id' => auth()->user()->user_id,
            'name' => $validatedData['name'],
            'image' => $imagePath,
            'price' => $validatedData['price'],
            'quantity' => $validatedData['quantity'],
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category_id'],
        ]);

        return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso!');
    }

    public function edit(string $productId, string $sellerId, string $categoryId)
    {
        $product = Product::where('product_id', $productId)
            ->where('seller_id', $sellerId)
            ->where('category_id', $categoryId)
            ->firstOrFail();

        if (auth()->user()->function_id == 2 && $product->seller_id !== auth()->id()) {
            abort(403, 'Acesso não autorizado.');
        }

        $categories = Category::all();

        return view('editar-produto', compact('product', 'categories'));
    }


    public function update(Request $request, $product_id, $seller_id, $category_id)
    {
        $product = Product::where('product_id', $product_id)
            ->where('seller_id', $seller_id)
            ->where('category_id', $category_id)
            ->firstOrFail();

        if (auth()->user()->function_id == 2 && $product->seller_id != auth()->user()->user_id) {
            abort(403, 'Você não tem permissão de realizar essa ação.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|string',
            'price' => 'required|numeric|min:0.01',
            'quantity' => 'required|integer|min:0',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,category_id',
        ]);

        Product::where('product_id', $product_id)
            ->where('seller_id', $seller_id)
            ->where('category_id', $category_id)
            ->update($validatedData);

        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }
    public function destroy(string $productId, string $sellerId, string $categoryId)
    {
        $product = Product::where('product_id', $productId)
            ->where('seller_id', $sellerId)
            ->where('category_id', $categoryId)
            ->firstOrFail();

        if (auth()->user()->function_id == 2 && $product->seller_id != auth()->user()->user_id) {
            abort(403, 'Você não tem permissão para realizar essa ação.');
        }

        Product::where('product_id', $productId)
            ->where('seller_id', $sellerId)
            ->where('category_id', $categoryId)
            ->delete();

        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso!');
    }
}