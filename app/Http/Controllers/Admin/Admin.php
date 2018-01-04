<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Services\AdminService;
use App\Presenters\DateFormat\DateFormatPresenterFactory;

use Validator;

class Admin extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    //
    public function index(Request $request, DateFormatPresenterFactory $dateFormatPresenterFactory)
    {
        $queryData = $request->query();
        $lists     = $this->adminService->pages(env('PRE_PAGE'), $queryData);
        $viewData  = ['lists' => $lists];

        $locale = 'en';
        $dateFormatPresenterFactory->create($locale);

        return view('admin.admin.list', $viewData);
    }

    public function add(Request $request)
    {
        // var_dump($request->route()->uri());
        // var_dump($request->route()->methods());
        // var_dump($request->route()->getPrefix());
        // var_dump($request->route()->getName());
        // var_dump($request->route()->getActionName());
        // var_dump($request->route()->getAction());

        return view('admin.admin.detail', $this->viewData);
    }

    public function detail(Request $request, $id)
    {

        // var_dump($request->route()->uri());
        // var_dump($request->route()->methods());
        // var_dump($request->route()->getPrefix());
        // var_dump($request->route()->getName());
        // var_dump($request->route()->getActionName());
        // var_dump($request->route()->getAction());

        $data = $this->adminService->getByID($id);
        if ($data) {
            $this->viewData['data'] = $data;

            return view('admin.admin.detail', $this->viewData);
        }

    }

    public function ajaxAdd(Request $request)
    {
        $validator = $this->validateForm($request, __FUNCTION__);

        if ($validator->passes()) {

            $posts = $request->input();

            $this->responseData['status'] = true;
        } else {
            $this->responseData['message'] = join('<br />', $validator->messages()->all());
        }

        return response()->json($this->responseData);
    }

    public function ajaxUpdate(Request $request, $id)
    {
        $validator = $this->validateForm($request, __FUNCTION__);

        if ($validator->passes() && $id == $request->input('a_id')) {
            $posts = $request->input();

            $this->responseData['status'] = true;
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
            'a_status'    => '狀態',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        return $validator;
    }
}
