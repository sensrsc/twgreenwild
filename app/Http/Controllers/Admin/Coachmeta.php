<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CoachMetaRepository;
use App\Repositories\CoachRepository;
use Illuminate\Http\Request;
use Validator;

class Coachmeta extends Controller
{
    protected $coachMetaRepository;
    protected $coachRepository;
    protected $responseData;
    protected $destinationPath;

    public function __construct(CoachMetaRepository $repository, CoachRepository $coachRepository)
    {
        $this->coachMetaRepository = $repository;
        $this->coachRepository     = $coachRepository;
        $this->responseData        = [
            'status'  => false,
            'message' => '',
        ];
        $this->destinationPath = public_path('upload/coach/license/');
    }

    public function index(Request $request, $type, $cId)
    {
        $coach = $this->coachRepository->getByID($cId);
        if (isset(config('common.coach_meta_types')[$type]) && $coach) {
            $queryData = $request->query();
            $lists     = $this->coachMetaRepository->pages($type, $cId, env('PRE_PAGE'), $queryData);

            return view('admin.coach.meta_list', compact('lists', 'type', 'coach'));
        }

        $this->notFound($type);
    }

    public function add($type, $cId)
    {
        $coach = $this->coachRepository->getByID($cId);
        if (isset(config('common.coach_meta_types')[$type]) && $coach) {
            return view('admin.coach.meta_detail', compact('coach', 'type'));
        }

        $this->notFound($type);
    }

    public function detail($id)
    {
        $data = $this->coachMetaRepository->getByID($id);
        if ($data) {
            $coach = $data->coach;
            $type = $data->cm_type;

            return view('admin.coach.meta_detail', compact('data', 'type', 'coach'));
        }
        // error not found
        $this->notFound();
    }

    public function ajaxAdd(Request $request)
    {
        $validator = $this->validateForm($request);
        if ($validator->passes()) {
            $posts = $request->input();
            if ($posts['cm_type'] == '2') {
                $posts['cm_picture'] = $this->uploadFile($request);
            }

            $cmId                         = $this->coachMetaRepository->insert($posts);
            $this->responseData['status'] = ($cmId > 0) ? true : false;
            if ($this->responseData['status']) {
                $this->responseData['c_id']    = $posts['cm_cid'];
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
                $posts['cm_picture'] = $fileName;
            }

            $this->responseData['status'] = $this->coachMetaRepository->update($id, $posts);
            if ($this->responseData['status']) {
                $this->responseData['c_id']    = $posts['cm_cid'];
                $this->responseData['message'] = '修改成功';
            }
        } else {
            $this->responseData['message'] = join('<br />', $validator->messages()->all());
        }

        return response()->json($this->responseData);
    }

    public function ajaxDelete(Request $request, $cId)
    {
        $cmIds = explode(',', $request->input('cm_id'));
        if ($cmIds) {
            $this->responseData['status'] = $this->coachMetaRepository->multiUpdate($cId, $cmIds, ['cm_status' => 2]);
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
        if ($request->hasFile('cm_picture')) {
            $fileName            = $request->file('cm_picture')->getClientOriginalName();
            $posts['cm_picture'] = $fileName;

            $request->file('cm_picture')->move($this->destinationPath, $fileName);
            return $fileName;
        }

        return '';
    }

    private function notFound($type)
    {
        $typeName = '';
        if (!isset(config('common.coach_meta_types')[$type])) {
            $typeName = '型別';
        }

        $message = array(
            'title'    => '錯誤',
            'caption'  => '錯誤',
            'message'  => '查無教練' . $typeName . '資料',
            'url'      => '/admin/coach',
            'linkName' => '返回教練管理',
        );
        return view('admin.message', $message);
    }

    protected function validateForm(Request $request)
    {
        $pictureRule = 'required|';
        if ($request->input('cm_id') == 0 && $request->input('cm_type') != '2') {
            $pictureRule = '';
        }
        $pictureRule .= 'image';

        $rules = [
            'cm_name'    => 'required|max:255',
            'cm_picture' => $pictureRule,
        ];

        $attributes = [
            'cm_name'    => '名稱',
            'cm_picture' => '證照',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        return $validator;
    }
}
