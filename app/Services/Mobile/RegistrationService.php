<?php

namespace App\Services\Mobile;

use App\Enums\TokenAbility;
use App\Models\User;
use App\Notifications\Mobile\VerificationCodeNotification;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

/**
 * Class RegistrationService.
 */
class RegistrationService
{

    public function create(FormRequest $request)
    {
        $data = $request->validated();
        $verification_code = random_int(100000, 999999);
        $data['verification_code'] = $verification_code;

        return DB::transaction(function () use ($data, $verification_code) {
            if ($data['role'] == 'client') {
                $user = User::create($data);
            } else {
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'verification_code' => $data['verification_code'],
                ]);
                $user->kitchen()->create([
                    'city_id' => $data['city_id'],
                    'name' => $data['kitchen_name'],
                    'description' => $data['kitchen_description'],
                    'address' => $data['kitchen_address'],
                    'phone_number' => $data['kitchen_phone_number'],
                    'second_phone_number' => $data['kitchen_second_phone_number'] ?? null,
                    'verification_code' => $data['verification_code'],

                ]);
            }
            $user->assignRole(Role::where('name', $data['role'])->first()->name);
            $user->notify(new VerificationCodeNotification($verification_code));

            return $user->append('role_name');
        });
    }


    public function resendVerificationCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'exists:users,email'],
        ]);

        DB::transaction(function () use ($request) {

            $user = User::where('email', $request->email)->first();
            if ($user->email_verified_at != null)
                return throw new Exception('هذا البريد الإلكتروني مفعل بالفعل', 400);

            $verificationCode = mt_rand(100000, 999999);
            $user->update([
                'verification_code' => $verificationCode,
            ]);
            $user->notify(new VerificationCodeNotification($verificationCode));
        });
    }


    public function verifyEmail(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'verification_code' => ['required', 'string']
        ]);
        $user = User::where('email', $data['email'])->first();

        if ($user->email_verified_at != null) {
            return throw new Exception('هذا البريد الإلكتروني مفعل بالفعل', 400);
        }
        if ($user->verification_code != $data['verification_code']) {
            return throw new Exception('رمز التحقق غير صحيح', 403);
        }

        $user = DB::transaction(function () use ($user) {
            $user->update([
                'email_verified_at' => now(),
                'verification_code' => null
            ]);
            $user->hasRole(['chef']) ? $user->load('kitchen') : null;
            return $user;
        });

        $accessToken = $user->createToken(
            'access_token',
            [TokenAbility::ACCESS_API->value],
            now()->addMinutes(config('sanctum.expiration'))
        );

        $refreshToken = $user->createToken(
            'refresh_token',
            [TokenAbility::ISSUE_ACCESS_TOKEN->value],
            now()->addDays(7)
        );

        return [
            'user' => $user->append('role_name'),
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken
        ];
    }
}
