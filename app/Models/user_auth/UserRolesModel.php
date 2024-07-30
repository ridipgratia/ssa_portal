<?php

namespace App\Models\user_auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRolesModel extends Model
{
    use HasFactory;
    protected $table = 'user_roles';
    protected $fillable = [
        'user_id',
        'role_id'
    ];
    public function user_credentials()
    {
        return $this->belongsTo(UserCredentials::class, 'user_id');
    }
}
