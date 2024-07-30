<?php

namespace App\Models\user_auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserCredentials extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'user_credentials';
    protected $fillable = [
        'unique_code',
        'name',
        'email_id',
        'phone_no',
        'password',
        'remember_token',
    ];
    protected $hidden = [
        'password'
    ];
}