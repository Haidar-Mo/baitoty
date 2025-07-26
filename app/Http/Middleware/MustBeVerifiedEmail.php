<?php

namespace App\Http\Middleware;

use App\Notifications\VerificationCodeNotification;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustBeVerifiedEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->email_verified_at == null) {
            $verificationCode = random_int(100000, 999999);
            $request->user()->update(['verification_code' => $verificationCode]);
            $request->user()->notify(new VerificationCodeNotification($verificationCode));
            return response()->json(['message' => 'Your Email not verified yet'], 403);
        }
        return $next($request);
    }
}
