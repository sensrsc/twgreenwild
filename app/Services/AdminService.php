<?php

namespace App\Services;

use App\Repositories\AdminRepository;
use App\Models\Admin;
use Session;
use Request;

class AdminService
{
    public function checkLogin(Admin $admin, $account, $password)
    {
        if (!empty($admin) && $admin->a_status == 1 && 
            password_verify($password, $admin->a_password)) {

            return true;
        }
        return false;
    }

    public function checkCaptcha($checkCode)
    {
        return (strtolower(session()->get('captcha_word')) == strtolower($checkCode))? true : false;
    }

    public function login(Admin $admin)
    {
        if (!empty($admin)) {
            $admin->ip = Request::ip();
            $admin->last_login = date('Y-m-d H:i:s');
            $admin->save();

            session()->put('admin', $admin);
            session()->put('admin_ckfinder', '9');
            return true;
        }
        return false;
    }

}
