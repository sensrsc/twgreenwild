<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\UserService;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Session;
use Validator;

class Register extends Controller
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
        $msg = '';
        if ($request->isMethod('post')) {
            $validator = $this->validateForm($request);
            if ($validator->passes()) {
                $user = $this->userRepository->insert($request->input());
                if (!empty($user)) {
                    session()->forget('access_token');
                    $this->userService->login($user);
                    return redirect('/');
                }
                $msg = '註冊失敗';
            } else {
                $msg = join('<br />', $validator->messages()->all());
            }
        }

        $helper = $this->facebook->getRedirectLoginHelper();
        $email  = '';
        $fbid   = '';
        $token  = '';

        if ($get = $request->query()) {
            try {
                $helper->getPersistentDataHandler()->set('state', $get['state']);
                $accessToken = $helper->getAccessToken();
                $token       = $accessToken->getValue();
                if ($token) {
                    session()->put('access_token', $token);
                }
            } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                if ($e->getCode() == 100 && strpos($e->getMessage(), 'authorization code has expired') !== false) {

                }
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                // echo 'Facebook SDK returned an error: ' . $e->getMessage();
                // exit;
            }
        }

        if (!$token) {
            $token = session()->get('access_token', $token);
        }
        if ($token) {
            $response = $this->facebook->get('/me?fields=id,name,email', $token);
            $me       = $response->getGraphUser();
            $fbid     = $me->getID();
            $email    = $me->getEmail();
            $name     = $me->getName();
        }

        $permissions = ['email'];
        $loginUrl    = $helper->getLoginUrl(url('/register'), $permissions);

        return view('front/register', compact('loginUrl', 'email', 'name', 'fbid', 'msg'));
    }

    protected function validateForm(Request $request)
    {
        $rules = [
            'account'    => 'required|max:100|email|unique:user,u_account',
            'password'   => 'required|min:6|max:15',
            'repassword' => 'required|same:password',
        ];

        $attributes = [
            'account'    => 'Email',
            'password'   => '密碼',
            'repassword' => '確認密碼',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        return $validator;
    }
}
