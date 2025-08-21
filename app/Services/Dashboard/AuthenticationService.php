<?php

namespace App\Services\Dashboard;

use App\Enums\TokenAbility;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

/**
 * Class AuthenticationService.
 */
class AuthenticationService
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', operator: $request->email)->first();
        if (!$user)
            throw new \Exception('Unauthenticated', 401);
        $user->hasRole(['admin']) ?: throw new \Exception('Unauthorized', 403);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'البريد أو كلمة المرور غير صحيحة'], 401);
        }
        $accessToken = $user->createToken(
            'access_token',
            [TokenAbility::ACCESS_API->value, "role:$user->role"],
            Carbon::now()->addMinutes(config('sanctum.expiration'))
        );

        $refreshToken = $user->createToken(
            'refresh_token',
            [TokenAbility::ISSUE_ACCESS_TOKEN->value],
            Carbon::now()->addDays(7)
        );

        return [
            'access_token' => $accessToken->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken,
            'user' => $user->append('role_name'),
        ];
    }


    public function logout()
    {
        auth()->user()->tokens()->delete();
        return null;
    }
}
