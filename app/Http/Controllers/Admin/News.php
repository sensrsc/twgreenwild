<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\NewsService;
use Validator;

class News extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index(Request $request)
    {
        $queryData              = $request->query();
        $this->viewData['lists'] = $this->newsService->pages(env('PRE_PAGE'), $queryData);

        return view('admin.news.list', $this->viewData);
    }

    public function add()
    {
        return view('admin.news.detail', $this->viewData);
    }

    public function detail($id)
    {
        $this->viewData['data'] = $this->newsService->getByID($id);
        if ($this->viewData['data']) {
            return view('admin.news.detail', $this->viewData);
        }

        // error not found

    }

    public function ajaxAdd(Request $request)
    {
        $validator = $this->validateForm($request);

        $this->uploadFile($request);
        if ($validator->passes()) {
            $posts = $request->input();

            $this->responseData['status'] = $this->newsService->insertData($posts);
            if ($this->responseData['status']) {
                $this->responseData['message'] = '修改成功';
            }
        } else {
            $this->responseData['message'] = join('<br />', $validator->messages()->all());
        }

        return response()->json($this->responseData);
    }

    public function ajaxUpdate(Request $request, $id)
    {
        $validator = $this->validateForm($request);
        $data = $this->newsService->getByID($id);
        if ($validator->passes() && !empty($data)) {
            $posts = $request->input();

            $this->responseData['status'] = $this->newsService->updateData($id, $posts);
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
            'n_title'   => 'required|max:50',
            'n_content' => 'required',
            'n_status'  => 'required',
            'n_cover'   => 'mimes:jpeg,jpg,png',
        ];

        $messages = [
            'required' => ':attribute 的欄位是必要的。',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        return $validator;
    }

    protected function uploadFile(Request $request)
    {
        $this->responseData['files'] = $request->allFiles();

        $this->responseData['cover'] = $request->hasFile('cover');
        $this->responseData['file']  = $request->file('cover');
        if ($request->hasFile('cover')) {
            $path                           = public_path('upload/images/news/');
            $this->responseData['mimetype'] = $request->file('cover')->getMimeType();

            $this->responseData['name']      = $request->file('cover')->getClientOriginalName();
            $this->responseData['extension'] = $request->file('cover')->getClientOriginalExtension();
            $this->responseData['types']     = $request->file('cover')->getClientMimeType();
            // $this->responseData['move'] = $request->file('cover')->move($path, 'test.jpg');
            $this->responseData['path'] = $path;
            return $request->file('cover');
        }
        return [];
    }

}
