<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Validator;

class Member extends Controller
{
    protected $userService;
    protected $userRepository;
    protected $orderRepository;

    public function __construct(UserService $userService, UserRepository $userRepository, OrderRepository $orderRepository)
    {
        $this->userService     = $userService;
        $this->userRepository  = $userRepository;
        $this->orderRepository = $orderRepository;
    }

    public function info(Request $request)
    {
        $msg = '';
        $uID = session()->get('user')->u_id;
        if ($request->isMethod('post')) {
            $validator = $this->validateForm($request);
            if ($validator->passes()) {
                $isUpdate = $this->userRepository->update($uID, $this->userService->dataTrans($request->input()));
                $msg      = '資料修改失敗';
                if ($isUpdate) {
                    $msg = '修改成功';
                }
            } else {
                $msg = join('<br />', $validator->messages()->all());
            }
        }

        $user = $this->userRepository->getByID($uID);

        return view('front/member_info', compact('user', 'msg'));
    }

    public function order(Request $request)
    {
        $queryData = $request->query();
        $lists     = $this->orderRepository->pages(env('PRE_PAGE'), $queryData);

        return view('front/member_order', compact('lists'));
    }

    protected function validateForm(Request $request)
    {
        $rules = [
            'name'            => 'required|max:40',
            'phone'           => 'required|max:20',
            'gender'          => 'required',
            'year'            => 'required',
            'month'           => 'required',
            'day'             => 'required',
            'address'         => 'required|max:250',
            'emergency_name'  => 'required',
            'emergency_phone' => 'required',
        ];

        $attributes = [
            'name'            => '姓名',
            'phone'           => '電話',
            'gender'          => '性別',
            'year'            => '生日-年',
            'month'           => '生日-月',
            'day'             => '生日-日',
            'address'         => '地址',
            'emergency_name'  => '緊急聯絡人姓名',
            'emergency_phone' => '緊急聯絡人電話',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        return $validator;
    }
}
