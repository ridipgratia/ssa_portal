<?php

namespace App\traits\user_auth;

use App\our_modules\reuse_modules\ReuseModules;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                    $res_data['message'] = Auth::guard('user_guard')->user();
                    $dash_boards = [
                        'admin',
                        'employee',
                        'commissioner'
                    ];
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
}
