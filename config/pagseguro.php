<?php

return [
    'env' => env('PAGSEGURO_ENV', 'sandbox'),

    'email' => env('PAGSEGURO_EMAIL'),
    'token' => env('PAGSEGURO_TOKEN'),

    'url' => [
        'checkout' => env('PAGSEGURO_ENV', 'sandbox') == 'sandbox'
            ? 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout'
            : 'https://ws.pagseguro.uol.com.br/v2/checkout',

        'redirect' => env('PAGSEGURO_ENV', 'sandbox') == 'sandbox'
            ? 'https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code='
            : 'https://pagseguro.uol.com.br/v2/checkout/payment.html?code=',
    ]
];