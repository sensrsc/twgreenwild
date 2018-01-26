<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AdminRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Validator;

class Admin extends Controller
{
    protected $adminRepository;
    protected $responseData;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
        $this->responseData    = [
            'status'  => false,
            'message' => '',
        ];
    }

    public function index(Request $request)
    {
        $queryData = $request->query();
        $lists     = $this->adminRepository->pages(env('PRE_PAGE'), $queryData);

        return view('admin.admin.list', compact('lists'));
    }

    public function add(Request $request)
    {
        $adminStatus = config('common.admin_status');
        unset($adminStatus[2]);

        return view('admin.admin.detail', compact('adminStatus'));
    }

    public function detail(Request $request, $id)
    {
        $data = $this->adminRepository->getByID($id);
        if ($data) {
            $adminStatus = config('common.admin_status');
            unset($adminStatus[2]);

            return view('admin.admin.detail', compact('data', 'adminStatus'));
        }
        $message = array(
            'title'    => '錯誤',
            'caption'  => '錯誤',
            'message'  => '查無管理者資料',
            'url'      => '/admin/admin',
            'linkName' => '反回管理者管理',
        );
        return view('admin.message', $message);
    }

    public function ajaxAdd(Request $request)
    {
        $validator = $this->validateForm($request, __FUNCTION__);

        if ($validator->passes()) {
            $posts = $request->input();

            $this->responseData['status'] = $this->adminRepository->insertAdmin($posts);
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
        $validator = $this->validateForm($request, __FUNCTION__);
        if ($validator->passes() && $id == $request->input('a_id')) {
            $admin = $this->adminRepository->getByID($id);
            if ($admin) {
                $posts = $request->input();

                $this->responseData['status'] = $this->adminRepository->updateAdmin($admin, $posts);
                if ($this->responseData['status']) {
                    $this->responseData['message'] = '修改成功';
                }    
            } else {
                $this->responseData['message'] = '查無管理者資料';
            }
        } else {
            $this->responseData['message'] = join('<br />', $validator->messages()->all());
        }

        return response()->json($this->responseData);
    }

    protected function validateForm(Request $request, $function)
    {
        $rules = [
            'a_account' => 'required|max:50|unique:admin,a_account',
            'a_name'    => 'required|max:50',
            'a_status'  => 'required',
        ];

        if ($function == 'ajaxAdd') {
            $rules['a_password']  = 'required|min:4|max:20';
            $rules['re_password'] = 'required|min:4|max:20|same:a_password';
        } else {
            if (!empty($request->a_password)) {
                $rules['a_password']  = 'required|min:4|max:20';
                $rules['re_password'] = 'required|min:4|max:20|same:a_password';
            }
            $rules['a_account'] .= ',' . $request->input('a_id') . ',a_id';
        }

        $messages = [
            'required' => ':attribute 的欄位是必要的。',
            'unique'   => ':attribute 已經存在',
        ];

        $attributes = [
            'a_account'   => '帳號',
            'a_password'  => '密碼',
            're_password' => '確認密碼',
            'a_name'      => '暱稱',
            'a_status'    => '狀態',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        return $validator;
    }
}
