<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AdminService;
use App\Repositories\AdminRepository;
use App\Libraries\Captcha;

class Login extends Controller
{
	protected $adminService;
    protected $adminRepository;

	public function __construct(AdminService $adminService, AdminRepository $adminRepository)
	{
	    $this->adminService = $adminService;
        $this->adminRepository = $adminRepository;
	}

    public function index(Request $request)
    {
    	if ($request->isMethod('post')) {
            $posts = $request->input();
            $admin = $this->adminRepository->getByAccount($request->input('account'));
            if ($admin) {
                $isLogin = $this->adminService->checkLogin($admin, $request->input('account'), $request->input('password'));
                $checkCaptcha = $this->adminService->checkCaptcha($request->input('check_code'));
                if ($isLogin && $checkCaptcha) {
                    $this->adminService->login($admin);
                    return redirect('/admin/index');
                } else {
                    $errorMsg = '請確認帳號或密碼是否正確';
                    if (!$checkCaptcha) {
                        $errorMsg = '請確認驗證碼是否正確';
                    }
                }
            } else {
                $errorMsg = '請確認帳號或密碼是否正確';
            }
            
    	}
        if (session()->has('admin')) {
            return redirect('/admin/index');
        }

    	return view('admin.login_view', compact('errorMsg'));
    }

    public function logout()
    {
        session()->forget('admin');
        session()->forget('admin_ckfinder');
        return redirect('/admin');
    }

    public function captcha()
    {
    	$captcha = new Captcha();
    	$captcha->generate();
    }
}
