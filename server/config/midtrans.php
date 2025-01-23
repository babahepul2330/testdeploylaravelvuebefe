<?php

return [
    'merchantId' => env('MIDTRANS_MERCHANT_ID', ''),
    'clientKey' => env('MIDTRANS_CLIENT_KEY', ''),
    'serverKey' => env('MIDTRANS_SERVER_KEY', ''),
    'environment' => env('MIDTRANS_ENVIRONMENT', false),
    'base_url' => env('MIDTRANS_ENVIRONMENT', false)
        ? "https://api.midtrans.com"
        : "https://api.sandbox.midtrans.com",
];
