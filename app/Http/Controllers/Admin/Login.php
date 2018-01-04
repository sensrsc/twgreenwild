<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AdminService;
use App\Libraries\Captcha;

class Login extends Controller
{
	protected $adminService;

	public function __construct(AdminService $adminService)
	{
	    $this->adminService = $adminService;
	}

    public function index(Request $request)
    {
    	if ($request->isMethod('post')) {
            $posts = $request->input();
            $isLogin = $this->adminService->login($request->input('account'), $request->input('password'));
            $checkCaptcha = $this->adminService->checkCaptcha($request->input('check_code'));
            
            if ($isLogin && $checkCaptcha) {
                return redirect('/admin/index');
            } else {
                $this->viewData['error_msg'] = '請確認帳號或密碼是否正確';
                if (!$checkCaptcha) {
                    $this->viewData['error_msg'] = '請確認驗證碼是否正確';
                }
            }
    	}
        if (session()->has('admin')) {
            return redirect('/admin/index');
        }

    	return view('admin.login_view', $this->viewData);
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
