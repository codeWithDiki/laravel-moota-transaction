<?php

return [
    "moota_url" => env("MOOTA_URL", "https://app.moota.co"),

    "v2_apikey" => env("MOOTA_V2_APIKEY"),

    "webhook_prefix" => env("MOOTA_WEBHOOK_PREFIX", "webhook/moota-transaction"),

    "mode" => env('MOOTA_MODE', 'testing'),

    // Contoh : \App\Models\Transaction::class
    "transactionable_model" => "",

    // Contoh : "success" => "berhasil"
    "status_converter" => [],

    "unique_code" => true,

    "unique_code_start" => 1,

    "unique_code_end" => 199,
];