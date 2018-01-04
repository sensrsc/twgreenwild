<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
	public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'admin';

    protected $primaryKey = 'a_id';

    protected $fillable = ['a_account', 'a_password', 'a_name', 'a_email', 'a_status', 'ip', 'last_login'];

    protected $hidden = ['a_password', 'remember_token'];
}
