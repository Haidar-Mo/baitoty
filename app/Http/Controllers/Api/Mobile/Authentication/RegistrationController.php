<?php

namespace App\Http\Controllers\Api\Mobile\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\RegistrationRequest;
use App\Services\Mobile\RegistrationService;
use App\Traits\FirebaseNotificationTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class RegistrationController extends Controller
{
    use FirebaseNotificationTrait, ResponseTrait;

    public function __construct(public RegistrationService $service)
    {
    }

    /**
     * Register an email into the application
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function create(RegistrationRequest $request)
    {
        try {
            $this->service->create($request);
            return $this->showMessage("تم التسجيل بنجاح. تم إرسال رمز التحقق إلى البريد الإلكتروني.", 200);
        } catch (Exception $e) {
            return $this->showError($e, 'حدث خطأ أثناء إنشاء الحساب');
        }
    }

    /**
     * Resend verification code for an deactivated existing email
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function resendVerificationCode(Request $request)
    {
        try {
            $this->service->resendVerificationCode($request);
            return response()->json(['message' => 'تم إعادة إرسال رمز التحقق بنجاح'], 200);
        } catch (Exception $e) {
            return $this->showError($e, 'حدث خطأ أثناء إعادة إرسال رمز التحقق');
        }
    }

    /**
     * Verify the previously registered email.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function verifyEmail(Request $request)
    {
        try {
            $data = $this->service->verifyEmail($request);
            return response()->json([
                'message' => 'تم التحقق من البريد الإلكتروني بنجاح',
                'access_token' => $data['access_token']->plainTextToken,
                'refresh_token' => $data['refresh_token']->plainTextToken,
                'user' => $data['user'],
            ], 200);
        } catch (Exception $e) {
            return $this->showError($e, 'حدث خطأ أثناء التحقق من الحساب');
        }
    }

    /**
     * Delete authenticated user's account 
     * @param \Illuminate\Http\Request $request
     *
     */
    public function deleteAccount()
    {
        $user = Auth::user();
        Auth::user()->tokens()->delete();
        $user->delete();
    }
}
