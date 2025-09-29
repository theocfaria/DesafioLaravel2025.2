<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class PagSeguroController extends Controller
{
    public function createCheckout(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'product_quantity' => 'required|integer|min:1',
        ]);

        $url = config('services.pagseguro.checkout_url');
        $token = config('services.pagseguro.token');

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->input('product_quantity');

        $items = [
            [
                'name' => $product->name,
                'quantity' => (int) $quantity,
                'unit_amount' => $product->price * 100
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-type' => 'application/json'
        ])->withoutVerifying()->post($url, [
                    'reference_id' => uniqid(),
                    'items' => $items
                ]);

        if ($response->successful()) {
            Order::create([
                'reference_id' => $response['reference_id'],
                'status' => 'paid',
                'product_id' => $product->product_id,
                'seller_id' => $product->seller_id,
                'category_id' => $product->category_id,
                'buyer_id' => Auth::id(),
                'quantity' => $quantity,
                'total_amount' => $product->price * $quantity
            ]);

            $sale = Sale::create([
                'user_id' => $product->seller_id,
                'total_value' => $product->price * $quantity
            ]);

            $sale->products()->attach($product->product_id, [
                'quantity' => $quantity,
                'price_at_sale' => $product->price
            ]);

            $pay_link = data_get($response->json(), 'links.1.href');

            return redirect()->away($pay_link);
        }
    }
}
