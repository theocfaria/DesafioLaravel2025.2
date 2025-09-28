<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PagSeguro\Configuration\Configure;
use PagSeguro\Domains\Requests\Checkout;

class CheckoutController extends Controller
{
    public function process(Request $request, Product $product)
    {
        $seller = $product->seller;

        if (!$seller->pagseguro_authorization_code) {
            return back()->with('error', 'Este vendedor não está habilitado para receber pagamentos.');
        }

        $sale = Sale::create([
            'user_id' => Auth::id(), 
            'seller_id' => $seller->id,
            'total_value' => $product->price,
            'status' => 'pending',
        ]);

        $sale->products()->attach($product->product_id, [
            'quantity' => 1,
            'price_at_sale' => $product->price
        ]);

        try {
            $config = new Configure();
            $config->setEnvironment(env('PAGSEGURO_ENV'));
            $config->setApplicationCredential(
                env('PAGSEGURO_APP_ID'),
                env('PAGSEGURO_APP_KEY')
            );
            $config->setCharset('UTF-8');

            $checkout = new Checkout();
            $checkout->addItems()->withParameters(
                $product->product_id,
                $product->name,
                1,
                number_format($product->price, 2, '.', '')
            );
            $checkout->setCurrency('BRL');
            $checkout->setReference($sale->sale_id); 
            $checkout->setRedirectUrl(url('/dashboard'));
            $checkout->setNotificationUrl(route('checkout.notification'));

            $url = $checkout->register($config, $seller->pagseguro_authorization_code);

            return redirect()->away($url);

        } catch (\Exception $e) {
            $sale->products()->detach(); 
            $sale->delete(); 
            \Log::error('Erro ao processar PagSeguro: ' . $e->getMessage());
            return back()->with('error', 'Ocorreu um erro ao comunicar com o PagSeguro. Tente novamente.');
        }
    }

    public function notification(Request $request)
    {
        try {
            $config = new Configure();
            $config->setEnvironment(env('PAGSEGURO_ENV'));
            $config->setApplicationCredential(
                env('PAGSEGURO_APP_ID'),
                env('PAGSEGURO_APP_KEY')
            );

            $transaction = \PagSeguro\Services\Application\Notification::check($config, $request->input('notificationCode'));
            $sale = Sale::find($transaction->getReference());

            if (!$sale || $sale->status !== 'pending') {
                return response()->json(['status' => 'ignored'], 200);
            }

            if (in_array($transaction->getStatus()->getId(), [3, 4])) {
                $sale->status = 'paid';
                $sale->pagseguro_transaction_code = $transaction->getCode();
                $sale->save();

                $seller = User::find($sale->seller_id);
                $seller->increment('balance', $sale->total_value);
            }
            else if ($transaction->getStatus()->getId() == 7) {
                 $sale->status = 'canceled';
                 $sale->save();
            }

            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {
            \Log::error('Erro no Webhook PagSeguro: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }
}