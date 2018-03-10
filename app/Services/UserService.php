<?php

namespace App\Services;

use App\Models\User;
use Request;

class UserService
{
    public function __construct()
    {
        
    }

    public function checkLogin(User $user, $account, $password)
    {
        if (!empty($user) && $user->u_status == 1 && 
            password_verify($password, $user->u_password)) {

            return true;
        }
        return false;
    }

    public function checkFacebookLogin(User $user)
    {
        if (!empty($user) && $user->u_status == 1) {
            return true;
        }
        return false;
    }

    public function login(User $user)
    {
        if (!empty($user)) {
            $user->ip = Request::ip();
            $user->last_login = date('Y-m-d H:i:s');
            $user->save();

            session()->put('user', $user);

            return true;
        }
        return false;
    }

}
