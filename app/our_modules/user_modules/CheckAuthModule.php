<?php

namespace App\our_modules\user_modules;

use App\Models\user_auth\UserRolesModel;
use App\our_modules\reuse_modules\ReuseModules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckAuthModule
{
    public $check_logged_in;
    public $auth_message;
    public $role;
    public function __construct($role = null)
    {
        $this->role = $role;
        $this->check_logged_in = true;
    }
    // -------------- check logged in ------------
    public function checkLoggedIn()
    {
        if (Auth::guard('user_guard')->user()) {
            $this->check_logged_in = true;
        } else {
            $this->check_logged_in = false;
            $this->auth_message = "You are not logged in !";
        }
        return $this;
    }
    // ----------- check active user -------------
    public function checkActiveUser()
    {
        if ($this->check_logged_in) {
            if (Auth::guard('user_guard')->user()->active == 1) {
                $this->check_logged_in = true;
            } else {
                $this->check_logged_in = false;
                $this->auth_message = "Your account is deatived !";
            }
        }
        return $this;
    }
    // --------------- check logged user role -------------------
    public function checkLoggedRole()
    {
        if ($this->check_logged_in) {
            $query = [
                ['user_id', Auth::guard('user_guard')->user()->id],
                isset($this->role) ? ['role_id', $this->role] : [null]
            ];
            $user_role=ReuseModules::isAvailable(new UserRolesModel(),$query);
            if ($user_role) {
                $this->check_logged_in = true;
                $this->role = $user_role->role_id;
            } else {
                $this->check_logged_in = false;
                $this->auth_message = "Your role is not authenticable !";
            }
        }
        return $this;
    }
    // -------------- check one logged at a time -------------
    public function checkOneDeviceLogged(){
        if($this->check_logged_in){
            $logged_user=Auth::guard('user_guard')->user();
            if($logged_user->remember_token!==Session::getId()){
                $this->check_logged_in=false;
                $this->auth_message="Another Device Logged , Please Login Again !";
            }else{
                $this->check_logged_in=true;
            }
        }
        return $this;
    }
}
