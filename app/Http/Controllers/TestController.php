<?php

namespace App\Http\Controllers;

use App\Traits\FirebaseNotificationTrait;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use FirebaseNotificationTrait;


    public function sendNotification(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required',
                'title' => 'required',
                'body' => 'required',
            ]);
            return $this->unicast($request, $request->token);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], $e->getCode());
        }
    }
}
