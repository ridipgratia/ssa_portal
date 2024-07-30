<?php

namespace App\Http\Controllers\user_auth;

use App\Http\Controllers\Controller;
use App\traits\user_auth\UserAuthTraits;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    use UserAuthTraits;
}
