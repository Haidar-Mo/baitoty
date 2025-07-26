<?php

use App\Enums\TokenAbility;
use App\Http\Controllers\Api\Mobile\Authentication\RegistrationController;
use App\Http\Controllers\Api\Mobile\Authentication\AuthenticationController;
use App\Http\Controllers\Api\Mobile\Authentication\PasswordController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth/')->group(function () {



    Route::post('register', [RegistrationController::class, 'create']);
    Route::post('email/verify', [RegistrationController::class, 'verifyEmail']);
    Route::post('verification/code/resend', [RegistrationController::class, 'resendVerificationCode']);

    Route::post('send-reset-code', [PasswordController::class, 'sendResetCode']);
    Route::post('verify-reset-code', [PasswordController::class, 'verifyResetCode']);
    Route::post('reset-password', [PasswordController::class, 'resetPassword']);

    Route::post('login', [AuthenticationController::class, 'create']);




    Route::middleware([
        'auth:sanctum',
        'ability:' . TokenAbility::ISSUE_ACCESS_TOKEN->value,
    ])
        ->post('refresh-token', [AuthenticationController::class, 'refreshToken']);

    Route::middleware([
        'auth:sanctum',
        'ability:' . TokenAbility::ACCESS_API->value,
    ])->group(function () {

        Route::get('check-token', [AuthenticationController::class, 'checkTokenValidation']);
        Route::post('logout', [AuthenticationController::class, 'delete']);

        Route::post('account/delete', [RegistrationController::class, 'deleteAccount']);

        Route::post('password/change', [PasswordController::class, 'changePassword']);

    });



});