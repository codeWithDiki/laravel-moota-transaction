<?php

use Illuminate\Support\Facades\Route;

Route::post(config("moota-transaction.webhook_prefix", "webhook/moota-transaction"), 
[\Codewithdiki\LaravelMootaTransaction\Http\Controllers\MootaWebhookController::class, 'retrieve_webhook'])->name('laravel-moota-transaction-webhook');