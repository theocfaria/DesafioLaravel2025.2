<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class PagamentoController extends Controller
{
    /**
     * Ponto de entrada para o processo de checkout.
     */
    public function checkout(Request $request)
    {
        // 1. Valida os dados que vêm do formulário (ID do produto e quantidade)
        $validated = $request->validate([
            // CORREÇÃO: Altera a regra 'exists' para usar o nome correto da coluna (product_id)
            'product_id' => 'required|exists:products,product_id',
            'product_quantity' => 'required|integer|min:1',
        ]);

        // 2. Busca o produto no banco de dados para ter informações confiáveis
        // CORREÇÃO: Usa where() para especificar a coluna correta, pois findOrFail() usa 'id' por padrão.
        $product = Product::where('product_id', $validated['product_id'])->firstOrFail();
        $quantity = (int) $validated['product_quantity'];

        // 3. Verifica se a quantidade desejada está em estoque
        if ($product->quantity < $quantity) {
            return back()->with('error', 'A quantidade solicitada não está disponível em estoque.');
        }

        // 4. Tenta obter o token de acesso da API. Se falhar, retorna erro.
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return back()->with('error', 'Não foi possível comunicar com o sistema de pagamento. Tente novamente mais tarde.');
        }

        // 5. Monta os dados do item para enviar para a API do PagSeguro
        $item = [
            'name' => $product->name,
            'quantity' => $quantity,
            'unit_amount' => (int) ($product->price * 100), // Preço em centavos
        ];
        
        $url = config('services.pagseguro.url') . '/orders';

        // 6. Faz a chamada para a API para criar o pedido de pagamento
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->withoutVerifying()->post($url, [
            // CORREÇÃO: Usa a propriedade correta (product_id) para a referência.
            'reference_id' => 'prod_' . $product->product_id . '_' . uniqid(),
            'customer' => [ // Informações do comprador autenticado
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            'items' => [$item],
            'qr_codes' => [
                [
                    'amount' => [
                        'value' => (int) ($product->price * $quantity * 100)
                    ]
                ]
            ],
            'notification_urls' => [
                // route('pagseguro.notification') // Exemplo: URL para receber notificações de status
            ],
        ]);
        
        // 7. Processa a resposta da API
        if ($response->successful()) {
            $responseData = $response->json();
            
            // Tenta encontrar o link de pagamento de forma segura
            $payLink = '';
            foreach ($responseData['links'] ?? [] as $link) {
                if (isset($link['rel']) && $link['rel'] === 'PAY') {
                    $payLink = $link['href'];
                    break;
                }
            }

            if (empty($payLink)) {
                Log::error('Link de pagamento não encontrado na resposta da PagSeguro.', $responseData);
                return back()->with('error', 'Não foi possível obter o link de pagamento.');
            }
            
            // Aqui você pode criar um registro no seu banco de dados para a ordem pendente, se desejar.

            return redirect()->away($payLink);

        } else {
            // Se falhar, registra o erro detalhado e mostra uma mensagem amigável
            Log::error('Falha na API PagSeguro ao criar pedido.', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
            return back()->with('error', 'Erro ao iniciar o checkout com o PagSeguro. Tente novamente mais tarde.');
        }
    }

    /**
     * Obtém um token de acesso válido da API do PagSeguro, usando cache.
     *
     * @return string|null O token de acesso ou null em caso de falha.
     */
    private function getAccessToken(): ?string
    {
        // Verifica se já temos um token válido no cache
        if (Cache::has('pagseguro_access_token')) {
            return Cache::get('pagseguro_access_token');
        }

        $url = config('services.pagseguro.url') . '/oauth2/token';
        $appId = config('services.pagseguro.app_id');
        $appKey = config('services.pagseguro.app_key');

        // Faz a requisição para obter um novo token
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->withoutVerifying()->post($url, [
            'grant_type' => 'client_credentials',
            'client_id' => $appId,
            'client_secret' => $appKey,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $accessToken = $data['access_token'];
            $expiresIn = $data['expires_in'] - 300; // Guarda por 5 minutos a menos, por segurança

            // Armazena o novo token no cache
            Cache::put('pagseguro_access_token', $accessToken, $expiresIn);

            return $accessToken;
        }

        // Se falhar, registra o erro e retorna null
        Log::critical('Falha CRÍTICA ao obter Access Token do PagSeguro.', [
            'status' => $response->status(),
            'response' => $response->body(),
        ]);

        return null;
    }
}
