<?php

namespace App\Models\user_auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
class UserCredentials extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guard = 'user_guard';
    protected $table = 'user_credentials';
    protected $fillable = [
        'unique_code',
        'name',
        'email_id',
        'phone_no',
        'password',
        'remember_token',
        'active'
    ];
    protected $hidden = [
        'password'
    ];
}
