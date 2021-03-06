<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryLevelRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Validator;

class CategoryLevel extends Controller
{
    protected $categoryRepository;
    protected $categoryLevelRepository;
    protected $responseData;

    public function __construct(CategoryRepository $categoryRepository, CategoryLevelRepository $repository)
    {
        $this->categoryRepository      = $categoryRepository;
        $this->categoryLevelRepository = $repository;
    }

    public function index(Request $request, $cId)
    {
        $category = $this->categoryRepository->getByID($cId);
        if ($category) {
            $queryData         = $request->query();
            $queryData['c_id'] = $cId;
            $lists             = $this->categoryLevelRepository->pages(env('PRE_PAGE'), $queryData);

            return view('admin.category.level_list', compact('category', 'lists'));
        }
        $message = array(
            'title'    => '錯誤',
            'caption'  => '錯誤',
            'message'  => '查無行程分類資料',
            'url'      => '/admin/category',
            'linkName' => '反回行程分類管理',
        );
        return view('admin.message', $message);
    }

    public function add($cId)
    {
        $category = $this->categoryRepository->getByID($cId);
        if ($category) {
            return view('admin.category.level_detail', compact('category'));
        }
        $message = array(
            'title'    => '錯誤',
            'caption'  => '錯誤',
            'message'  => '查無行程分類資料',
            'url'      => '/admin/category',
            'linkName' => '反回行程分類管理',
        );
        return view('admin.message', $message);
    }

    public function detail($id)
    {
        $data = $this->categoryLevelRepository->getByID($id);
        if ($data) {
            $category = $this->categoryRepository->getByID($data->c_id);
            return view('admin.category.level_detail', compact('data', 'category'));
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

            $clId = $this->categoryLevelRepository->insert($posts);
            $this->responseData['status'] = ($clId > 0)? true : false;
            if ($this->responseData['status']) {
                $this->responseData['c_id'] = $posts['c_id'];
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
        $data      = $this->categoryLevelRepository->getByID($id);
        if ($validator->passes() && !empty($data)) {
            $posts = $request->input();

            $this->responseData['status'] = $this->categoryLevelRepository->update($id, $posts);
            if ($this->responseData['status']) {
                $this->responseData['c_id'] = $posts['c_id'];
                $this->responseData['message'] = '修改成功';
            }
        } else {
            $this->responseData['message'] = join('<br />', $validator->messages()->all());
        }

        return response()->json($this->responseData);
    }

    public function ajaxDelete(Request $request)
    {
        $clId         = $request->input('cl_id');
        $data = $this->categoryLevelRepository->getByID($clId);
        if ($data) {
            $this->responseData['status'] = $this->categoryLevelRepository->update($clId, ['cl_status' => 2]);
            if ($this->responseData['status']) {
                $this->responseData['message'] = '刪除成功';
            }
        } else {
            $this->responseData['message'] = '請確認資料是否正確';
        }

        return response()->json($this->responseData);
    }

    public function ajaxCategoryLevel($cId)
    {
        $levels = $this->categoryLevelRepository->getByCategory($cId);
        if ($levels) {
            $this->responseData['status'] = ($levels)? true : false;
            if ($this->responseData['status']) {
                $this->responseData['message'] = '成功';
                $this->responseData['datas'] = $levels;
            }
        } else {
            $this->responseData['message'] = join('<br />', $validator->messages()->all());
        }

        return response()->json($this->responseData);
    }

    protected function validateForm(Request $request)
    {
        $rules = [
            'c_id'      => 'required',
            'cl_title'  => 'required|max:20',
            // 'cl_status' => 'required',
        ];

        $attributes = [
            'c_id'      => '分類',
            'cl_title'  => '等級名稱',
            // 'cl_status' => '等級狀態',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        return $validator;
    }
}
