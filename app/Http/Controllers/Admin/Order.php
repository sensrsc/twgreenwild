<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Validator;

class Order extends Controller
{
    protected $orderService;
    protected $orderRepository;
    protected $responseData;

    public function __construct(OrderService $service, OrderRepository $repository, UserRepository $userRepository)
    {
        $this->orderService    = $service;
        $this->userRepository  = $userRepository;
        $this->orderRepository = $repository;
        $this->responseData    = [
            'status'  => false,
            'message' => '',
        ];
    }

    public function index(Request $request)
    {
        $queryData = $request->query();
        $lists     = $this->orderRepository->pages(env('PRE_PAGE'), $queryData);

        return view('admin.order.list', compact('lists'));
    }

    public function add($uID = null)
    {
        $user = $this->userRepository->getByID($uID);
        $data = $uID ? $this->orderService->userFieldTransToOrderFeild($user) : '';

        return view('admin.order.detail', compact('data', 'user'));
    }

    public function detail($id)
    {
        $data = $this->orderRepository->getByID($id);
        if ($data) {
            $user           = $data->user;
            $data->o_detail = json_decode($data->o_detail);
            return view('admin.order.detail', compact('data', 'user'));
        }
        // error not found
        $message = array(
            'title'    => '錯誤',
            'caption'  => '錯誤',
            'message'  => '查無訂單資料',
            'url'      => '/admin/order',
            'linkName' => '反回訂單管理',
        );
        return view('admin.message', $message);
    }

    public function ajaxAdd(Request $request)
    {
        $validator = $this->validateForm($request);
        $posts     = $this->orderService->adminOrderDataProcess($request->input());
        $checkDate = $this->orderService->notApplyDateCheck($posts);
        if ($validator->passes()) {
            $oID                          = $this->orderRepository->insert($posts);
            $this->responseData['status'] = ($oID > 0) ? true : false;
            if ($this->responseData['status']) {
                $this->responseData['message'] = '新增成功';
            }
        } else {
            $this->responseData['message'] = join('<br />', $validator->messages()->all());
        }

        return response()->json($this->responseData);
    }

    public function ajaxUpdate(Request $request, $id)
    {
        $validator = $this->validateForm($request);
        $data      = $this->orderRepository->getByID($id);
        $posts     = $this->orderService->adminOrderDataProcess($request->input());
        $checkDate = $this->orderService->notApplyDateCheck($posts);
        if ($validator->passes() && !empty($data) && $checkDate) {

            $isUpdate                     = $this->orderRepository->update($id, $posts);
            $this->responseData['status'] = ($isUpdate) ? true : false;
            if ($this->responseData['status']) {
                $this->responseData['message'] = '修改成功';
            }
        } else {
            $this->responseData['message'] = join('<br />', $validator->messages()->all());
            if (!$checkDate) {
                $this->responseData['message'] = '報名日期在不接單區間';
            }
        }

        return response()->json($this->responseData);
    }

    protected function validateForm(Request $request)
    {
        $rules = [
            'u_id'          => 'required|exists:user,u_id',
            'apply_date'    => 'required|date|date_format:Y-m-d',
            'adult_num'     => 'required|numeric',
            'child_num'     => 'required|numeric',
            'apply_name'    => 'required|max:45',
            'apply_gender'  => 'required|numeric',
            'apply_phone'   => 'required|max:20',
            'apply_address' => 'required|max:100',
            'apply_email'   => 'required|email|max:45',
            't_id'          => 'required|numeric',
        ];

        $totalPeople = $request->input('adult_num') + $request->input('child_num');
        if ($totalPeople == 1) {
            $rules['apply_identity']        = 'required';
            $rules['apply_birthday']        = 'required|date|date_format:Y-m-d';
            $rules['apply_height']          = 'required|numeric';
            $rules['apply_weight']          = 'required|numeric';
            $rules['apply_foot']            = 'required|numeric';
            $rules['apply_emergency_name']  = 'required';
            $rules['apply_emergency_phone'] = 'required';
        }

        $attributes = [
            'u_id'                  => '帳號',
            'apply_date'            => '報名日期',
            'adult_num'             => '大人人數',
            'child_num'             => '小孩人數',
            'apply_name'            => '姓名',
            'apply_gender'          => '性別',
            'apply_phone'           => '電話',
            'apply_address'         => '地址',
            'apply_email'           => 'Email',
            't_id'                  => '行程',
            'apply_identity'        => '身份證號',
            'apply_birthday'        => '生日',
            'apply_height'          => '身高',
            'apply_weight'          => '體重',
            'apply_foot'            => '腳掌',
            'apply_emergency_name'  => '緊急聯絡人姓名',
            'apply_emergency_phone' => '緊急聯絡人電話',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        return $validator;
    }

}
