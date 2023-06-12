<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Auth\ProfileUpdateRequest;
class ProfileUpdateController extends Controller
{
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $validatedData = $request->validated();

        $user->update($validatedData);

        $user = $user->refresh();

        $success['user'] = $user;
        $success['success'] = true;

        return response()->json($success,200);
    }
}
