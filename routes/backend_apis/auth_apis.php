<?php

use App\Http\Controllers\user_auth\UserAuthController;
use Illuminate\Support\Facades\Route;
// --------------- user login ---------------
Route::post('/login', [UserAuthController::class, 'loginPost']);
Route::group(['middleware' => ['OneDeviceLogged','APIuserAuth:2']], function () {
    // ---------------- user test dashboard ----------------
    Route::get('/test-dash', [UserAuthController::class, 'testDash']);
});

// --------------- user logout ---------------
Route::get('/logout', [UserAuthController::class, 'logout']);
