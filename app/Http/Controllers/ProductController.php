<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show($productId, $sellerId, $categoryId)
    {
        $product = Product::where('product_id', $productId)
            ->where('seller_id', $sellerId)
            ->where('category_id', $categoryId)
            ->firstOrFail();

        $product->load('seller', 'category');

        return view('produto', [
            'product' => $product
        ]);
    }
}