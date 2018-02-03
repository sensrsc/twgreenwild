<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\NewsRepository;
use Illuminate\Http\Request;
use Validator;

class News extends Controller
{
    protected $newsRepository;
    protected $responseData;

    public function __construct(NewsRepository $repository)
    {
        $this->newsRepository = $repository;
        $this->responseData   = [
            'status'  => false,
            'message' => '',
        ];
    }

    public function index(Request $request)
    {

        $queryData = $request->query();
        $lists     = $this->newsRepository->pages(env('PRE_PAGE'), $queryData);

        return view('admin.news.list', compact('lists'));
    }

    public function add()
    {
        return view('admin.news.detail');
    }

    public function detail($id)
    {
        $data = $this->newsRepository->getByID($id);
        if ($data) {
            return view('admin.news.detail', compact('data'));
        }
        // error not found
        $message = array(
            'title'    => '錯誤',
            'caption'  => '錯誤',
            'message'  => '查無最新消息資料',
            'url'      => '/admin/news',
            'linkName' => '反回最新消息管理',
        );
        return view('admin.message', $message);
    }

    public function ajaxAdd(Request $request)
    {
        $validator = $this->validateForm($request);

        if ($validator->passes()) {
            $posts = $request->input();

            $nId                          = $this->newsRepository->insert($posts);
            $this->responseData['status'] = ($nId > 0) ? true : false;
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
        $data      = $this->newsRepository->getByID($id);
        if ($validator->passes() && !empty($data)) {
            $posts = $request->input();

            $isUpdate                     = $this->newsRepository->update($id, $posts);
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
            'n_subject' => 'required|max:50',
            'n_content' => 'required',
            'n_status'  => 'required',
        ];

        $messages = [
            'required' => ':attribute 的欄位是必要的。',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        return $validator;
    }

}
