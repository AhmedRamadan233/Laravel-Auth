<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ProfileUpdateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('setapplang')->prefix('{locale}')->group(function(){
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [LoginController::class, 'login']);
    
    Route::post('password/forget-password', [ForgetPasswordController::class, 'forgetPassword']);
    Route::post('password/reset-password', [ResetPasswordController::class, 'passwordReset']);
});



Route::middleware(['auth:sanctum' , 'setapplang'])->prefix('{locale}')->group(function () {
    Route::get('profile', function (Request $request) {
        return $request->user();
    });
    Route::put('profile', [ProfileUpdateController::class, 'update']);

    Route::post('email-verification', [EmailVerificationNotificationController::class, 'email_verification']);
    Route::get('email-verification', [EmailVerificationNotificationController::class, 'sendEmailVerification']);

});