<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripePaymentController extends Controller
{
    public function createIntent(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $intent = PaymentIntent::create([
            'amount' => $request->amount,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);

        return response()->json([
            'clientSecret' => $intent->client_secret
        ]);
    }
}
