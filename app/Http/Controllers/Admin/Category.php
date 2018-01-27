<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryDescriptionRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Validator;

class Category extends Controller
{
    protected $categoryRepository;
    protected $categoryDescriptionRepository;
    protected $responseData;
    protected $destinationPath;

    public function __construct(CategoryRepository $repository, CategoryDescriptionRepository $categoryDescriptionRepository)
    {
        $this->categoryRepository            = $repository;
        $this->categoryDescriptionRepository = $categoryDescriptionRepository;
        $this->responseData                  = [
            'status'  => false,
            'message' => '',
        ];
        $this->destinationPath = public_path('upload/file/category/');
    }

    public function index(Request $request)
    {
        $queryData = $request->query();
        $lists     = $this->categoryRepository->pages(env('PRE_PAGE'), $queryData);

        return view('admin.category.list', compact('lists'));
    }

    public function add()
    {
        $descriptions = [];
        return view('admin.category.detail', compact('descriptions'));
    }

    public function detail($id)
    {
        $data = $this->categoryRepository->getByID($id);
        if ($data) {
            $descriptions = $this->categoryDescriptionRepository->getCategoryDescriptions($id);
            return view('admin.category.detail', compact('data', 'descriptions'));
        }
        // error not found
        $message = array(
            'title'    => '錯誤',
            'caption'  => '錯誤',
            'message'  => '查無行程分類資料',
            'url'      => '/admin/category',
            'linkName' => '反回行程分類管理',
        );
        return view('admin.message', $message);
    }

    public function ajaxAdd(Request $request)
    {
        $validator = $this->validateForm($request);
        if ($validator->passes()) {
            $posts = $request->input();
            if ($request->hasFile('c_file')) {
                $fileName        = $request->file('c_file')->getClientOriginalName();
                $posts['c_file'] = $fileName;
                $request->file('c_file')->move($this->destinationPath, $fileName);
            }

            $cId = $this->categoryRepository->insert($posts);
            $insertDescription = $this->categoryDescriptionRepository->processCategoryDescription($cId, $posts);
            $this->responseData['status'] = ($cId > 0 && $insertDescription)? true : false;
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
        $data      = $this->categoryRepository->getByID($id);
        if ($validator->passes() && !empty($data)) {
            $posts = $request->input();
            if ($request->hasFile('c_file')) {
                $fileName        = $request->file('c_file')->getClientOriginalName();
                $posts['c_file'] = $fileName;
                $request->file('c_file')->move($this->destinationPath, $fileName);
            }

            $isUpdate = $this->categoryRepository->update($id, $posts);
            $isDescriptionUpdate = $this->categoryDescriptionRepository->processCategoryDescription($id, $posts);
            $this->responseData['status'] = ($isUpdate && $isDescriptionUpdate)? true : false;
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
            'c_title'  => 'required|max:50',
            'c_status' => 'required',
            'c_file'   => 'mimes:doc,docx,xls,xlsx',
            'cd_type'  => 'required|array',
            'cd_title' => 'required|array',
        ];

        $attributes = [
            'c_title'  => '分類名稱',
            'c_status' => '分類狀態',
            'c_file'   => '報名檔案',
            'cd_title' => '說明名稱',
            'cd_type'  => '說明類型',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        return $validator;
    }

}
