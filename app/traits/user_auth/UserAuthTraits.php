<?php

namespace App\traits\user_auth;

use App\our_module\reuse_module\ReuseModules;
use App\our_modules\user_modules\UserModule;
use App\Rules\ValidatePassword;
use App\Rules\ValidatePhoneNumber;
use Illuminate\Http\Request;

trait UserAuthTraits
{
    // ---------------------- create account for employee ------------------
    public function createAccount(Request $request)
    {
        // if($request->ajax()){
        $res_data = [
            'status' => 400,
            'message' => ''
        ];
        $request_field = [
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => ['required', new ValidatePhoneNumber()],
            'password' => ['required', new ValidatePassword()]
        ];
        $validator = ReuseModules::reuseValidator($request, $request_field);
        if ($validator->fails()) {
            $res_data['message'] = $validator->errors()->all();
        } else {
            $res_data['status'] = 401;
            $email_id = preg_replace('/\s+/', ' ', $request->email);
            $phone_number = preg_replace('/\s+/', ' ', $request->phone_number);
            $unique_code = UserModule::generateUniqueCode($request->name);
            $res_data['unique_code'] = $unique_code;
        }
        return response()->json([
            'res_data' => $res_data
        ]);
        // }
    }
}
