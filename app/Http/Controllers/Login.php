<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\UserService;
use Facebook\Facebook;
use Illuminate\Http\Request;

class Login extends Controller
{
    protected $userService;
    protected $userRepository;
    protected $facebook;

    public function __construct(UserService $userService, UserRepository $userRepository)
    {
        $this->userService    = $userService;
        $this->userRepository = $userRepository;
        $this->facebook       = new \Facebook\Facebook([
            'app_id'                => env('FB_APP_ID', ''),
            'app_secret'            => env('FB_APP_SECRET', ''),
            'default_graph_version' => 'v2.11',
        ]);
    }

    public function index(Request $request)
    {
        $msg    = '';
        $helper = $this->facebook->getRedirectLoginHelper();
        if ($get = $request->query()) {
            try {
                $helper->getPersistentDataHandler()->set('state', $get['state']);
                $accessToken = $helper->getAccessToken();
                $token       = $accessToken->getValue();
                if ($token) {
                    $response = $this->facebook->get('/me?fields=id,name,email', $token);
                    $me       = $response->getGraphUser();
                    $fbid     = $me->getID();

                    $user    = $this->userRepository->getByFbID($fbid);
                    $isLogin = $this->userService->checkFacebookLogin($user);
                    if ($isLogin) {
                        $this->userService->login($user);
                    }
                }
            } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
            }
        }

        if ($request->isMethod('post')) {
            $user  = $this->userRepository->getByAccount($request->input('account'));
            if ($user) {
                $isLogin = $this->userService->checkLogin($user, $request->input('account'), $request->input('password'));
                if ($isLogin) {
                    $this->userService->login($user);
                    return redirect('/');
                } else {
                    $msg = '請確認帳號或密碼是否正確';
                }
            } else {
                $msg = '請確認帳號或密碼是否正確';
            }
        }
        if (session()->has('user')) {
            return redirect('/');
        }

        $permissions = ['email'];
        $loginUrl    = $helper->getLoginUrl(url('/login'), $permissions);

        return view('front/login', compact('msg', 'loginUrl'));
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }
}
