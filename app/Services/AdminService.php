<?php

namespace App\Services;

use App\Repositories\AdminRepository;
use Session;
use Request;

class AdminService extends BaseService
{
    public function __construct(AdminRepository $repository)
    {
        parent::__construct($repository);
    }

    public function checkCaptcha($checkCode)
    {
        return (strtolower(session()->get('captcha_word')) == strtolower($checkCode))? true : false;
    }

    public function login($account, $password)
    {
        $admin = $this->repository->getByAccount($account);
        if (!empty($admin) && $admin->a_status == 1 && 
            password_verify($password, $admin->a_password)) {
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
