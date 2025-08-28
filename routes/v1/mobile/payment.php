<?php

use App\Enums\TokenAbility;
use App\Http\Controllers\Api\Mobile\StripePaymentController;
use Illuminate\Support\Facades\Route;

Route::prefix('payments')
    ->middleware([
        'auth:sanctum',
        'ability:' . TokenAbility::ACCESS_API->value,
    ])
    ->group(function () {

        Route::post('/create-payment-intent', [StripePaymentController::class, 'createIntent']);
        Route::post('/stripe/webhook', [StripePaymentController::class, 'handleWebhook']);
    });
