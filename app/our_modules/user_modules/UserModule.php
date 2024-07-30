<?php

namespace App\our_modules\user_modules;

class UserModule
{
    // ----------------- generate unique code -----------------
    public static function generateUniqueCode($name)
    {
        $name = strtoupper(substr($name, 0, 3));
        return 'emp-' . $name . '/' . rand(1000, 9999) . '-';
    }
}
