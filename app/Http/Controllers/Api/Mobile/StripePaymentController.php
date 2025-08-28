<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Webhook;

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

    public function handleWebhook(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $this->handlePaymentSucceeded($paymentIntent);
                break;

            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                $this->handlePaymentFailed($paymentIntent);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    private function handlePaymentSucceeded($paymentIntent)
    {
        $order = Order::where('payment_intent_id', $paymentIntent->id)->first();
        if ($order) {
            $order->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }
    }

    private function handlePaymentFailed($paymentIntent)
    {
        $order = Order::where('payment_intent_id', $paymentIntent->id)->first();
        if ($order) {
            $order->update(['status' => 'failed']);
        }
    }
}
