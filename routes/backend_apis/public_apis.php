<?php

use App\Http\Controllers\user_auth\UserAuthController;
use Illuminate\Support\Facades\Route;

// ----------------- create account ---------------
Route::post('/create-account', [UserAuthController::class, 'createAccount']);
