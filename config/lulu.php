<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Lulu API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration settings for Lulu Print API (Print-on-demand fulfillment).
    |
    */

    'client_key' => env('LULU_CLIENT_KEY', ''),
    'client_secret' => env('LULU_CLIENT_SECRET', ''),

    // 'sandbox' or 'production'
    'environment' => env('LULU_ENV', 'sandbox'),

    'default_shipping_level' => env('LULU_DEFAULT_SHIPPING_LEVEL', 'MAIL'),
    'default_country_code'   => env('LULU_DEFAULT_COUNTRY_CODE', 'US'),

    'endpoints' => [
        'sandbox' => [
            'auth' => 'https://api.sandbox.lulu.com/auth/realms/glasstree/protocol/openid-connect/token',
            'api'  => 'https://api.sandbox.lulu.com',
        ],
        'production' => [
            'auth' => 'https://api.lulu.com/auth/realms/glasstree/protocol/openid-connect/token',
            'api'  => 'https://api.lulu.com',
        ],
    ],
];

