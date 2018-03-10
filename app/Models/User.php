<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'user';

    protected $primaryKey = 'u_id';

    protected $fillable = ['u_name', 'u_account', 'u_password', 'fb_id', 'u_identity', 'u_email', 'u_phone', 'u_gender', 'u_birthday', 'u_height', 'u_weight', 'u_foot', 'u_emergency_name', 'u_emergency_phone', 'u_status'];

    protected $hidden = ['u_password'];
}
