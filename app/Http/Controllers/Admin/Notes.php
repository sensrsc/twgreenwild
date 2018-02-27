<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ActivitiesNotesRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Validator;

class Notes extends Controller
{
    //
    protected $activiesNotesRepository;
    protected $responseData;

    public function __construct(ActivitiesNotesRepository $repository, CategoryRepository $categoryRepository)
    {
        $this->activitiesNotesRepository = $repository;
        $this->categoryRepository      = $categoryRepository;
        $this->responseData            = [
            'status'  => false,
            'message' => '',
        ];
    }

    public function index(Request $request)
    {
        $queryData = $request->query();
        $lists     = $this->activitiesNotesRepository->pages(env('PRE_PAGE'), $queryData);

        return view('admin.notes.list', compact('lists'));
    }

    public function add()
    {
        $categorys = $this->categoryRepository->getAll();
        return view('admin.notes.detail', compact('categorys'));
    }

    public function detail($id)
    {
        $data = $this->activitiesNotesRepository->getByID($id);
        if ($data) {
            $categorys = $this->categoryRepository->getAll();
            return view('admin.notes.detail', compact('data', 'categorys'));
        }
        // error not found
        $message = array(
            'title'    => '錯誤',
            'caption'  => '錯誤',
            'message'  => '查無活動筆記資料',
            'url'      => '/admin/notes',
            'linkName' => '反回活動筆記管理',
        );
        return view('admin.message', $message);
    }

    public function ajaxAdd(Request $request)
    {
        $validator = $this->validateForm($request);
        if ($validator->passes()) {
            $posts = $request->input();

            $anId                         = $this->activitiesNotesRepository->insert($posts);
            $this->responseData['status'] = ($anId > 0) ? true : false;
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
        $data      = $this->activitiesNotesRepository->getByID($id);
        if ($validator->passes() && !empty($data)) {
            $posts = $request->input();

            $this->responseData['status'] = $this->activitiesNotesRepository->update($id, $posts);
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
        $ids = explode(',', $request->input('an_id'));
        if ($ids) {
            $this->responseData['status'] = $this->activitiesNotesRepository->multiUpdate($ids, ['an_status' => 2]);
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
            'an_name'   => 'required|max:255',
            'c_id'      => 'required',
            'an_body'   => 'required',
            // 'an_status' => 'required',
            'an_date'   => 'required|date|date_format:"Y-m-d"',
            'an_cover'  => 'required',
        ];

        $attributes = [
            'an_name'   => '筆記名稱',
            'c_id'      => '行程分類',
            'an_body'   => '筆記內容',
            // 'an_status' => '筆記狀態',
            'an_date'   => '筆記日期',
            'an_cover'  => '筆記封面',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        return $validator;
    }
}
