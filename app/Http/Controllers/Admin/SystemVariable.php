<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SystemVariableRepository;
use Illuminate\Http\Request;
use Validator;
use View;

class SystemVariable extends Controller
{
    protected $systemRepository;
    protected $responseData;

    public function __construct(SystemVariableRepository $repository)
    {
        $this->systemRepository = $repository;
        $this->responseData     = [
            'status'  => false,
            'message' => '',
        ];
    }

    public function index(Request $request)
    {
        $queryData = $request->query();
        $lists     = $this->systemRepository->pages(env('PRE_PAGE'), $queryData);

        return view('admin.system.list', compact('lists'));
    }

    public function add()
    {
        return view('admin.system.detail');
    }

    public function detail($id)
    {
        $data = $this->systemRepository->getByID($id);
        if ($data) {
            return view('admin.system.detail', compact('data'));
        }
        // error not found
        $message = array(
            'title'    => '錯誤',
            'caption'  => '錯誤',
            'message'  => '查無系統變數資料',
            'url'      => '/admin/system',
            'linkName' => '反回系統變數管理',
        );
        return view('admin.message', $message);
    }

    public function ajaxAdd(Request $request)
    {
        $validator = $this->validateForm($request);
        if ($validator->passes()) {
            $posts = $request->input();

            $svId                         = $this->systemRepository->insert($posts);
            $this->responseData['status'] = ($svId > 0) ? true : false;
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
        $data      = $this->systemRepository->getByID($id);
        if ($validator->passes() && !empty($data)) {
            $posts = $request->input();

            $isUpdate                     = $this->systemRepository->update($id, $posts);
            $this->responseData['status'] = ($isUpdate) ? true : false;
            if ($this->responseData['status']) {
                $this->responseData['message'] = '修改成功';
            }
        } else {
            $this->responseData['message'] = join('<br />', $validator->messages()->all());
        }

        return response()->json($this->responseData);
    }

    protected function validateForm(Request $request)
    {
        $rules = [
            'sv_name'  => 'required|max:50',
            'sv_key'   => 'required|max:50',
            'sv_value' => 'required',
        ];

        $attributes = [
            'sv_name'  => '變數說明',
            'sv_key'   => '變數名稱',
            'sv_value' => '變數值',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        return $validator;
    }

}
