<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StripePaymentController;



Route::prefix('v1/')->group(function () {

    Route::prefix('mobile')->group(function () {

        include __DIR__ . "/v1/mobile/auth.php";
        include __DIR__ . "/v1/mobile/chef/profile.php";
        include __DIR__ . "/v1/mobile/chef/meal.php";
        include __DIR__ . "/v1/mobile/chef/order.php";


        Route::prefix('client')->group(function () {
            include __DIR__ . "/v1/mobile/client/meal.php";
            include __DIR__ . "/v1/mobile/client/order.php";

        });

        include __DIR__ . "/v1/mobile/payment.php";

    });

    Route::prefix("dashboard")->group(function () {
        include __DIR__ . "/v1/dashboard/user.php";
        include __DIR__ . "/v1/dashboard/kitchen.php";
        include __DIR__ . "/v1/dashboard/order.php";
    });
});
