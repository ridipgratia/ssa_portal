<?php

namespace App\traits\user_auth;

use App\our_modules\reuse_modules\ReuseModules;
use App\our_modules\user_modules\UserModule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

trait UserAuthTraits
{
    // -------------- post login -----------------
    public function loginPost(Request $request)
    {
        // if($request->ajax()){
        $res_data = [
            'message' => '',
            'status' => 400
        ];
        $request_field = [
            'user_name' => 'required',
            'password' => 'required'
        ];
        $post_data = [
            'email_id' => $request->user_name,
            'password' => $request->password,
            'active' => 1
        ];
        $validator = ReuseModules::reuseValidator($request, $request_field);
        if ($validator->fails()) {
            $res_data['message'] = $validator->errors()->all();
        } else {
            $res_data['status'] = 401;
            try {
                if (Auth::guard('user_guard')->attempt($post_data)) {
                    $request->session()->regenerate();
                    $dash_boards = [
                        'admin',
                        'employee',
                        'commissioner'
                    ];
                    $remember_token = Session::getId();
                    UserModule::setLoginToken($remember_token);
                    $res_data['message'] = Auth::guard('user_guard')->user();
                } else {
                    $res_data['message'] = "Credentials not found !";
                }
            } catch (Exception $err) {
                $res_data['message'] = "Server error please try later !";
            }
        }
        return response()->json([
            'res_data' => $res_data
        ]);
        // }
    }
    // --------------- user test dash ---------------
    public function testDash(Request $request)
    {
        return response()->json([
            'auth_user' => Auth::guard('user_guard')->user()
        ]);
    }
    // -------------- user logout -------------
    public function logout(Request $request)
    {
        try {
            UserModule::setLoginToken();
            Auth::guard('user_guard')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } catch (Exception $err) {

        }
    }
}
