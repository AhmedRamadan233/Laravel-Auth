<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Notifications\LoginNotification;
class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (auth()->attempt($credentials)) {
            $user = Auth::user();
            
            $user->tokens()->delete();
            $token = $user->createToken(request()->userAgent());
            $success['token'] = $token->plainTextToken;
            $success['name'] = $user->first_name;
            $success['success'] = true;
            $user->notify(new LoginNotification());

            return response()->json($success, 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
