<?php

namespace App\traits\public_tratis;

use App\Models\user_auth\UserCredentials;
use App\Models\user_auth\UserRolesModel;
use App\our_modules\reuse_modules\ReuseModules;
use App\our_modules\user_modules\UserModule;
use App\Rules\ValidatePassword;
use App\Rules\ValidatePhoneNumber;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

trait PublicTrait
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
            $check = false;
            $check_duplicate = '';
            try {
                $check_duplicate = UserCredentials::where(function ($query) use ($email_id, $phone_number) {
                    $query->where('email_id', $email_id)
                        ->orWhere('phone_no', $phone_number);
                })->first();
                $check = true;
            } catch (Exception $err) {
                $res_data['message'] = "Server error please try later !";
            }
            if ($check) {
                if ($check_duplicate) {
                    $res_data['message'] = $check_duplicate->email_id == $email_id ? "Email id is already exists !" : "Phone number is already used";
                } else {
                    DB::beginTransaction();
                    try {
                        $save_user = UserCredentials::create(
                            [
                                'unique_code' => $unique_code,
                                'name' => $request->name,
                                'email_id' => $request->email,
                                'phone_no' => $request->phone_number,
                                'password' => Hash::make($request->password),
                            ]
                        );
                        if ($save_user) {
                            $save_user->unique_code = $unique_code . $save_user->id;
                            $save_user->save();
                            $save_role = UserRolesModel::create([
                                'user_id' => $save_user->id,
                                'role_id' => 2
                            ]);
                            DB::commit();
                            $res_data['message'] = "Account Created successfully !";
                            $res_data['status'] = 200;
                        }
                    } catch (Exception $err) {
                        DB::rollBack();
                        $res_data['message'] = "Server error please try later !";
                    }
                }
            }
        }
        return response()->json([
            'res_data' => $res_data
        ]);
        // }
    }
}
