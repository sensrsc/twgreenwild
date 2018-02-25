<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\CollectionVideoRepository;
use Illuminate\Http\Request;
use Validator;

class Video extends Controller
{
    //
    protected $collectionVideoRepository;
    protected $categoryRepository;
    protected $responseData;

    public function __construct(CollectionVideoRepository $repository, CategoryRepository $categoryRepository)
    {
        $this->collectionVideoRepository = $repository;
        $this->categoryRepository        = $categoryRepository;
        $this->responseData              = [
            'status'  => false,
            'message' => '',
        ];
    }

    public function index(Request $request)
    {
        $queryData = $request->query();
        $lists     = $this->collectionVideoRepository->pages(env('PRE_PAGE'), $queryData);
        $categorys = $this->categoryRepository->getAll();

        return view('admin.video.list', compact('lists', 'categorys'));
    }

    public function add()
    {
        $categorys = $this->categoryRepository->getAll();
        return view('admin.video.detail', compact('categorys'));
    }

    public function detail($id)
    {
        $data = $this->collectionVideoRepository->getByID($id);
        if ($data) {
            $categorys = $this->categoryRepository->getAll();
            return view('admin.video.detail', compact('data', 'categorys'));
        }
        // error not found
        $message = array(
            'title'    => '錯誤',
            'caption'  => '錯誤',
            'message'  => '查無活動影音資料',
            'url'      => '/admin/video',
            'linkName' => '反回活動影音管理',
        );
        return view('admin.message', $message);
    }

    public function ajaxAdd(Request $request)
    {
        $validator = $this->validateForm($request);
        if ($validator->passes()) {
            $posts = $request->input();

            $cvId                         = $this->collectionVideoRepository->insert($posts);
            $this->responseData['status'] = ($cvId > 0) ? true : false;
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
        $data      = $this->collectionVideoRepository->getByID($id);
        if ($validator->passes() && !empty($data)) {
            $posts = $request->input();

            $this->responseData['status'] = $this->collectionVideoRepository->update($id, $posts);
            if ($this->responseData['status']) {
                $this->responseData['message'] = '修改成功';
            }
        } else {
            $this->responseData['message'] = join('<br />', $validator->messages()->all());
        }

        return response()->json($this->responseData);
    }

    public function ajaxDelete(Request $request)
    {
        $cvIds = explode(',', $request->input('cv_id'));
        if ($cvIds) {
            $this->responseData['status'] = $this->collectionVideoRepository->multiUpdate($cvIds, ['cv_status' => 2]);
            if ($this->responseData['status']) {
                $this->responseData['message'] = '刪除成功';
            }
        } else {
            $this->responseData['message'] = '請確認資料是否正確';
        }

        return response()->json($this->responseData);
    }

    protected function validateForm(Request $request)
    {
        $rules = [
            'cv_name'         => 'required|max:255',
            'c_id'            => 'required',
            'cv_date'         => 'required|date|date_format:"Y-m-d"',
            'cv_description'  => 'required',
            'cv_youtube_link' => 'required|url',
        ];

        $attributes = [
            'cv_name'         => '影片名稱',
            'c_id'            => '行程分類',
            'cv_description'  => '影音說明',
            'cv_date'         => '影片日期',
            'cv_youtube_link' => '影片連結',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        return $validator;
    }
}
