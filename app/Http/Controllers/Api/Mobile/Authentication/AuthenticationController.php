<?php

namespace App\Http\Controllers\Api\Mobile\Authentication;

use App\Enums\TokenAbility;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    /**
     *  Handle an authentication attempt for a user.
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_token' => ['sometimes']
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'البريد أو كلمة المرور غير صحيحة'], 401);
        }
        if ($request->has('device_token')) {
            $user->update(['device_token' => $request->device_token]);
        }
        $user->tokens()->delete();

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

        return response()->json([
            'access_token' => $accessToken->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken,
            'user' => $user->append('role_name'),
        ], 200);
    }


    /**
     * Delete all user's access token and log the user out of the application.
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function delete()
    {
        auth()->user()->tokens()->delete();

        return response()->json(null, 204);
    }


    /**
     * Refresh an out of date token.
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        $accessToken = $user->createToken(
            'access_token',
            [TokenAbility::ACCESS_API->value, 'role:' . $user->roles?->first()->name],
            Carbon::now()->addMinutes(config('sanctum.expiration'))
        );

        $refreshToken = $user->createToken(
            'refresh_token',
            [TokenAbility::ISSUE_ACCESS_TOKEN->value],
            Carbon::now()->addMinutes(2 * config('sanctum.expiration'))
        );
        return response()->json([
            'message' => 'Token created successfully!',
            'access_token' => $accessToken->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken,
            'user' => $user,
        ]);
    }


    /**
     * Return 200 if the access_token Valid
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function checkTokenValidation()
    {
        return response()->json([
            'success' => true,
            'message' => 'Token is valid',
            'user' => request()->user(),
        ]);
    }
}
