<?php

use App\Http\Controllers\user_auth\UserAuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserAuthController::class, 'loginPost']);
