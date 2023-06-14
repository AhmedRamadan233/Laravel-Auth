<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Auth\ProfileUpdateRequest;
use App\Traits\ImageProcessiong;
class ProfileUpdateController extends Controller
{
    use ImageProcessiong;
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $validatedData = $request->validated();
    
        if ($request->hasFile('image')) {
            if ($user->image) {
                $this->deleteImage($user->image);
            }
            $validatedData['image'] = $this->saveImage($request->file('image'));
        }
    
        $user->update($validatedData);
    
        $user = $user->refresh();
        $user->image ? $user->image = $user->image_url : null;
    
        $success['user'] = $user;
        $success['success'] = true;
    
        return response()->json($success, 200);
    }
    
}
