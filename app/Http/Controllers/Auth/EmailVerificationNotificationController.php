<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\EmailVerificationNotificationRequest;
use Otp;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;

class EmailVerificationNotificationController extends Controller
{
    private $otp;

    public function __construct()
    {
        $this->otp = new Otp;
    }

    public function sendEmailVerification(Request $request){
        $request->user()->notify(new EmailVerificationNotification());
        $success['success : EmailVerificationNotification'] = true;
        return response()->json($success, 200);
    }
    public function email_verification(EmailVerificationNotificationRequest $request)
    {
        // Validate OTP
        $otp2 = $this->otp->validate($request->email, $request->otp);

        if (!$otp2->status) {
            return response()->json(['error' => $otp2], 401);
        }

        $user = User::where('email', $request->email)->first();
        //email_verified_at column in db of user
        $user->update(['email_verified_at' => now()]);
        $success['success email_verified_at'] = true;
        return response()->json($success, 200);
    }
}
