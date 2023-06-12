<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegistrationRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;

class RegisterController extends Controller
{
    public function register(RegistrationRequest $request)
    {
        $newUser = $request->validated();
        $newUser['password'] = Hash::make($newUser['password']);
        $newUser['role'] = 'user';
        $newUser['status'] = 'active';

        $user = User::create($newUser);

        $token = $user->createToken('user', ['app:all']);

        $success['token'] = $token->plainTextToken;

        $success['name'] = $user->first_name;
        $success['email'] = $user->email;

        $success['success'] = true;
        $user->notify(new EmailVerificationNotification());
        return response()->json($success, 200);
    }
}
