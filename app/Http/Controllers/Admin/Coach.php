<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CoachRepository;
use Illuminate\Http\Request;
use Validator;

class Coach extends Controller
{
    protected $coachRepository;
    protected $responseData;
    protected $destinationPath;

    public function __construct(CoachRepository $repository)
    {
        $this->coachRepository = $repository;
        $this->responseData    = [
            'status'  => false,
            'message' => '',
        ];
        $this->destinationPath = public_path('upload/coach/');
    }

    public function index(Request $request)
    {
        $queryData = $request->query();
        $lists     = $this->coachRepository->pages(env('PRE_PAGE'), $queryData);

        return view('admin.coach.list', compact('lists'));
    }

    public function add()
    {
        return view('admin.coach.detail');
    }

    public function detail($id)
    {
        $data = $this->coachRepository->getByID($id);
        if ($data) {
            return view('admin.coach.detail', compact('data'));
        }
        // error not found
        $this->notFound();
    }

    public function ajaxAdd(Request $request)
    {
        $validator = $this->validateForm($request);
        if ($validator->passes()) {
            $posts             = $request->input();
            $posts['c_avatar'] = $this->uploadFile($request);

            $cId                          = $this->coachRepository->insert($posts);
            $this->responseData['status'] = ($cId > 0) ? true : false;
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
        $data      = $this->coachRepository->getByID($id);
        if ($validator->passes() && !empty($data)) {
            $posts = $request->input();
            if ($fileName = $this->uploadFile($request)) {
                $posts['c_avatar'] = $fileName;
            }

            $this->responseData['status'] = $this->coachRepository->update($id, $posts);
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
        $cIds = explode(',', $request->input('c_id'));
        if ($cIds) {
            $this->responseData['status'] = $this->coachRepository->multiUpdate($cIds, ['c_status' => 2]);
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
        if ($request->hasFile('c_avatar')) {
            $fileName          = $request->file('c_avatar')->getClientOriginalName();
            $posts['c_avatar'] = $fileName;

            $request->file('c_avatar')->move($this->destinationPath, $fileName);
            return $fileName;
        }

        return '';
    }

    private function notFound()
    {
        $message = array(
            'title'    => '錯誤',
            'caption'  => '錯誤',
            'message'  => '查無教練資料',
            'url'      => '/admin/coach',
            'linkName' => '返回教練管理',
        );
        return view('admin.message', $message);
    }

    protected function validateForm(Request $request)
    {
    	$avatarRule = 'required|';
    	if ($request->input('c_id') > 0) {
    		$avatarRule = '';
    	}
    	$avatarRule .= 'image';

        $rules = [
            'c_name'   => 'required|max:50',
            'c_motto'  => 'required|max:255',
            'c_avatar' => $avatarRule,
            'c_seq'    => 'required|numeric',
        ];

        $attributes = [
            'c_name'   => '名字',
            'c_motto'  => '座右銘',
            'c_avatar' => '大頭照',
            'c_seq'    => '排序',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        return $validator;
    }
}
