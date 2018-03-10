<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IndexSlideRepository;
use Illuminate\Http\Request;
use Validator;

class Slide extends Controller
{
    protected $indexSlideRepository;
    protected $responseData;
    protected $destinationPath;

    public function __construct(IndexSlideRepository $repository)
    {
        $this->indexSlideRepository = $repository;
        $this->responseData         = [
            'status'  => false,
            'message' => '',
        ];
        $this->destinationPath = public_path('upload/slide/');
    }

    public function index(Request $request)
    {
        $queryData = $request->query();
        $lists     = $this->indexSlideRepository->pages(env('PRE_PAGE'), $queryData);

        return view('admin.slide.list', compact('lists'));
    }

    public function add()
    {
        return view('admin.slide.detail');
    }

    public function detail($id)
    {
        $data = $this->indexSlideRepository->getByID($id);
        if ($data) {
            return view('admin.slide.detail', compact('data'));
        }
        // error not found
        $this->notFound();
    }

    public function ajaxAdd(Request $request)
    {
        $validator = $this->validateForm($request);
        if ($validator->passes()) {
            $posts            = $request->input();
            $posts['is_file'] = $this->uploadFile($request);

            $isId                         = $this->indexSlideRepository->insert($posts);
            $this->responseData['status'] = ($isId > 0) ? true : false;
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
        $data      = $this->indexSlideRepository->getByID($id);
        if ($validator->passes() && !empty($data)) {
            $posts = $request->input();
            if ($fileName = $this->uploadFile($request)) {
                $posts['is_file'] = $fileName;
            }

            $this->responseData['status'] = $this->indexSlideRepository->update($id, $posts);
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
        $ids = explode(',', $request->input('is_id'));
        if ($ids) {
            $this->responseData['status'] = $this->indexSlideRepository->multiUpdate($ids, ['is_status' => 2]);
            if ($this->responseData['status']) {
                $this->responseData['message'] = '刪除成功';
            }
        } else {
            $this->responseData['message'] = '請確認資料是否正確';
        }

        return response()->json($this->responseData);
    }

    private function uploadFile(Request $request)
    {
        $posts = $request->input();
        if ($request->hasFile('is_file')) {
            $fileName         = $request->file('is_file')->getClientOriginalName();
            $posts['is_file'] = $fileName;

            $request->file('is_file')->move($this->destinationPath, $fileName);
            return $fileName;
        }

        return '';
    }

    private function notFound()
    {
        $message = array(
            'title'    => '錯誤',
            'caption'  => '錯誤',
            'message'  => '查無首頁輪播資料',
            'url'      => '/admin/slide',
            'linkName' => '返回首頁輪播管理',
        );
        return view('admin.message', $message);
    }

    protected function validateForm(Request $request)
    {
        $avatarRule = 'required|';
        if ($request->input('is_id') > 0) {
            $avatarRule = '';
        }
        $avatarRule .= 'image';

        $rules = [
            'is_title' => 'required|max:255',
            'is_file'  => $avatarRule,
            'is_start' => 'required|date_format:Y-m-d',
            'is_end'   => 'required|date_format:Y-m-d||after:is_start',
        ];
        if ($request->input('is_link')) {
            $rules['is_link'] = 'url';
        }

        $attributes = [
            'is_title' => '輪播名稱',
            'is_file'  => '輪播圖',
            'is_link'  => '輪播連結',
            'is_start' => '輪播開始日',
            'is_end'   => '輪播結束日',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        return $validator;
    }
}
