<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\TourRepository;
use Illuminate\Http\Request;
use Validator;

class Tour extends Controller
{
    protected $tourRepository;
    protected $responseData;

    public function __construct(TourRepository $repository)
    {
        $this->tourRepository = $repository;
        $this->responseData   = [
            'status'  => false,
            'message' => '',
        ];
    }

    public function index(Request $request)
    {

        $queryData = $request->query();
        $lists     = $this->tourRepository->pages(env('PRE_PAGE'), $queryData);
        $categorys = $this->tourRepository->getCategorys();
        $areas     = $this->tourRepository->getAreas();
        return view('admin.tour.list', compact('lists', 'categorys', 'areas'));
    }

    public function add()
    {
        $categorys = $this->tourRepository->getCategorys();
        $areas     = $this->tourRepository->getAreas();
        return view('admin.tour.detail', compact('categorys', 'areas'));
    }

    public function detail($id)
    {
        $data = $this->tourRepository->getByID($id);
        if ($data) {
            $categorys = $this->tourRepository->getCategorys();
            $areas     = $this->tourRepository->getAreas();
            return view('admin.tour.detail', compact('data', 'categorys', 'areas'));
        }
        // error not found
        $message = array(
            'title'    => '錯誤',
            'caption'  => '錯誤',
            'message'  => '查無行程資料',
            'url'      => '/admin/tour',
            'linkName' => '反回行程管理',
        );
        return view('admin.message', $message);
    }

    public function ajaxAdd(Request $request)
    {
        $validator = $this->validateForm($request);
        if ($validator->passes()) {
            $posts = $request->input();

            $tId                          = $this->tourRepository->insert($posts);
            $isInsert                     = $this->tourRepository->processTourDescriptions($tId, $posts);
            $this->responseData['status'] = ($tId > 0) ? true : false;
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
        $data      = $this->tourRepository->getByID($id);
        if ($validator->passes() && !empty($data)) {
            $posts = $request->input();

            $this->responseData['status'] = $this->tourRepository->update($id, $posts);
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
        $aId   = $request->input('a_id');
        $album = $this->albumRepository->getByID($aId);
        if ($album) {
            $this->responseData['status'] = $this->albumRepository->update($aId, ['a_status' => 2]);
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
            't_title'     => 'required|max:50',
            't_status'    => 'required',
            't_price'     => 'required|numeric',
            'min_people'  => 'required|numeric',
            'full_people' => 'required|numeric',
            'cd_id'       => 'required|array',
        ];

        if ($request->input('a_outside_link')) {
            $rules['a_outside_link'] = 'url';
        }

        $attributes = [
            't_title'     => '行程名稱',
            't_status'    => '行程狀態',
            't_price'     => '行程金額',
            'min_people'  => '最低人數',
            'full_people' => '滿團人數',
            'cd_id'       => '行程類型說明',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        return $validator;
    }

}
