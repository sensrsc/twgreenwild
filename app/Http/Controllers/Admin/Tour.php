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

        $queryData     = $request->query();
        $lists         = $this->tourRepository->pages(env('PRE_PAGE'), $queryData);
        $categorys     = $this->tourRepository->getCategorys();
        $areas         = $this->tourRepository->getAreas();
        $seasonFlagNum = $this->tourRepository->countRecommend('season');
        $hotFlagNum    = $this->tourRepository->countRecommend('hot');
        return view('admin.tour.list', compact('lists', 'categorys', 'areas', 'seasonFlagNum', 'hotFlagNum'));
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
            $levels    = $this->tourRepository->getLevelByCategory($data->c_id);
            $albums    = $this->tourRepository->getAlbumByCategory($data->c_id);
            return view('admin.tour.detail', compact('data', 'categorys', 'areas', 'levels', 'albums'));
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

    public function notaccept($id)
    {
        $data = $this->tourRepository->getByID($id);
        if ($data) {
            return view('admin.tour.detail_notaccept_date', compact('data'));
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

            $isUpdate                     = $this->tourRepository->update($id, $posts);
            $isDescUpdate                 = $this->tourRepository->processTourDescriptions($id, $posts);
            $this->responseData['status'] = ($isUpdate && $isDescUpdate) ? true : false;
            if ($this->responseData['status']) {
                $this->responseData['message'] = '修改成功';
            }
        } else {
            $this->responseData['message'] = join('<br />', $validator->messages()->all());
        }

        return response()->json($this->responseData);
    }

    public function ajaxUpdateNotAccept(Request $request, $id)
    {
        $validator = $this->validateNotAcceptDate($request);
        $data      = $this->tourRepository->getByID($id);
        if ($validator->passes() && !empty($data)) {
            $posts                        = $request->input();
            $isUpdate                     = $this->tourRepository->update($id, $posts);
            $this->responseData['status'] = ($isUpdate) ? true : false;
            if ($this->responseData['status']) {
                $this->responseData['message'] = '修改成功';
            }
        } else {
            $this->responseData['message'] = join('<br />', $validator->messages()->all());
        }

        return response()->json($this->responseData);
    }

    public function ajaxRecommend(Request $request, $id)
    {
        $data = $this->tourRepository->getByID($id);
        if (!empty($data)) {
            $type    = $request->input('type');
            $checked = $request->input('checked') == 'true' ? 1 : 0;
            
            if ($type == 'season') {
                $updateData['season_flag'] = $checked;
            } else {
                $updateData['hot_flag'] = $checked;
            }

            $isUpdate                     = $this->tourRepository->update($id, $updateData);
            $this->responseData['status'] = ($isUpdate) ? true : false;
            if ($this->responseData['status']) {
                $this->responseData[$type]     = $this->tourRepository->countRecommend($type);
                $this->responseData['message'] = '修改成功';
            }
        } else {
            $this->responseData['message'] = '請確認資料是否正確';
        }

        return response()->json($this->responseData);
    }

    public function ajaxSearch(Request $request)
    {
        $q = $request->query('q');

        $this->responseData['data'] = $this->tourRepository->search($q);

        return response()->json($this->responseData);
    }

    protected function validateForm(Request $request)
    {
        $rules = [
            'c_id'        => 'required|numeric',
            'a_id'        => 'required|numeric',
            'cl_id'       => 'required|numeric',
            'area_id'     => 'required|numeric',
            't_title'     => 'required|max:50',
            't_status'    => 'required',
            't_price'     => 'required|numeric',
            'min_people'  => 'required|numeric',
            'full_people' => 'required|numeric',
            'cd_id'       => 'required|array',
        ];

        $attributes = [
            'c_id'        => '行程分類',
            'a_id'        => '相簿',
            'cl_id'       => '等級',
            'area_id'     => '地區',
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

    private function validateNotAcceptDate(Request $request)
    {
        $rules = [
            'not_accept_start' => '',
            'not_accept_end'   => '',
        ];

        if ($request->input('not_accept_start') || $request->input('not_accept_end')) {
            $rules['not_accept_start'] = 'date|date_format:Y-m-d';
            $rules['not_accept_end']   = 'required|date|date_format:Y-m-d|after:not_accept_start';
        }

        $attributes = [
            'not_accept_start' => '不接單開始日',
            'not_accept_end'   => '不接單結束日',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        return $validator;
    }

}
