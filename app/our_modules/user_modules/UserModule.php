<?php

namespace App\our_modules\user_modules;

use App\Models\user_auth\UserCredentials;
use App\our_modules\reuse_modules\ReuseModules;
use Illuminate\Support\Facades\Auth;

class UserModule
{
    // ----------------- generate unique code -----------------
    public static function generateUniqueCode($name)
    {
        $name = strtoupper(substr($name, 0, 1));
        return 'emp-' . $name . '/' . rand(1000, 9999) . '-';
    }
    // --------------- Set login remember token------------
    public static function setLoginToken($token = null)
    {
        $query = [
            [
                'id', Auth::guard('user_guard')->user()->id,
            ],
            ['active', 1]
        ];
        $update_data = [
            'remember_token' => $token,
        ];

        ReuseModules::updateData(new UserCredentials(), $query, $update_data);
    }
}
