<?php

use App\Http\Controllers\public_controllers\PublicController;
use Illuminate\Support\Facades\Route;

// ----------------- create account ---------------
Route::post('/create-account', [PublicController::class, 'createAccount']);
