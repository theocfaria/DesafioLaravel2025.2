<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class CepController extends Controller
{
    public function show(string $cep) {
        $cepLimpo = preg_replace('/[^0-9]/', '', $cep);

        if(strlen($cepLimpo) != 8) {
            return response()->json([
                'error' => 'CEP inválido.',
            ], 400);
        }

        try {
            $response = Http::get("https://viacep.com.br/ws/{$cepLimpo}/json/");

            if($response->failed()) {
                return response()->json([
                    'error' => 'Não foi possível se comunicar com o serviço de CEP.'
                ], 503);
            }

            $data = $response->json();

            if (isset($data['erro']) && $data['erro'] === true) {
                return response()->json([
                    'error' => 'CEP não encontrado.'
                ], 404);
            }
            
            return response()->json($data);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro inesperado.'
            ], 500); 
        }
    }
}