<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Notifications\ResetPasswordVerificationNotification;
class ForgetPasswordController extends Controller
{
    public function forgetPassword(ForgetPasswordRequest $request){

        $input = $request->only('email');
        $user = User::where('email',$input)->first();
        $user->notify(new ResetPasswordVerificationNotification());
        $success ['success : ResetPasswordVerificationNotification'] = true;
        return response()->json($success,200);
    }
}
