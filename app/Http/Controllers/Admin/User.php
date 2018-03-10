<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class User extends Controller
{
    protected $userRepository;
    protected $responseData;

    public function __construct(UserRepository $repository)
    {
        $this->userRepository = $repository;
        $this->responseData   = [
            'status'  => false,
            'message' => '',
        ];
    }

    public function index(Request $request)
    {
        $queryData = $request->query();
        $lists     = $this->userRepository->pages(env('PRE_PAGE'), $queryData);

        return view('admin.user.list', compact('lists'));
    }

    public function info(Request $request, $id)
    {
        $data = $this->userRepository->getByID($id);
        if ($data) {
            return view('admin.user.info', compact('data'));
        }
        $message = array(
            'title'    => '錯誤',
            'caption'  => '錯誤',
            'message'  => '查無會員資料',
            'url'      => '/admin/reserveorder',
            'linkName' => '反回會員資料',
        );
        return view('admin.message', $message);
    }

}
