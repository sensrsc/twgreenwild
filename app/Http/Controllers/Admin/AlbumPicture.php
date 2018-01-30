<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AlbumPictureRepository;
use App\Repositories\AlbumRepository;
use Illuminate\Http\Request;
use Validator;

class AlbumPicture extends Controller
{
    protected $albumRepository;
    protected $albumPictureRepository;
    protected $responseData;
    protected $destinationPath;

    public function __construct(AlbumRepository $repository, AlbumPictureRepository $albumPictureRepository)
    {
        $this->albumRepository        = $repository;
        $this->albumPictureRepository = $albumPictureRepository;
        $this->responseData           = [
            'status'  => false,
            'message' => '',
        ];
        $this->destinationPath = public_path('upload/picture/');
    }

    public function index(Request $request, $aId)
    {
        $album = $this->albumRepository->getByID($aId);
        if ($album) {
            $queryData         = $request->query();
            $queryData['a_id'] = $aId;
            $lists             = $this->albumPictureRepository->pages(env('PRE_PAGE'), $queryData);

            return view('admin.album.picture_list', compact('album', 'lists'));
        }
        $this->notFound();
    }

    public function add($aId)
    {
        $album = $this->albumRepository->getByID($aId);
        if ($album) {
            return view('admin.album.picture_detail', compact('album'));
        }
        $this->notFound();
    }

    public function detail($id)
    {
        $data = $this->albumPictureRepository->getByID($id);
        if ($data) {
            $album = $this->albumRepository->getByID($data->a_id);
            return view('admin.album.picture_detail', compact('data', 'album'));
        }
        // error not found
        $this->notFound();
    }

    public function ajaxAdd(Request $request)
    {
        $validator = $this->validateForm($request);
        if ($validator->passes()) {
            $posts = $request->input();

            $uploadResult                 = $this->uploadFile($request);
            $this->responseData['status'] = ($uploadResult) ? true : false;
            if ($this->responseData['status']) {
                $this->responseData['a_id']    = $posts['a_id'];
                $this->responseData['message'] = '新增成功';
                $this->responseData['files']   = $uploadResult;
            }
        } else {
            $this->responseData['message'] = join('<br />', $validator->messages()->all());
        }

        return response()->json($this->responseData);
    }

    public function ajaxUpdate(Request $request, $id)
    {
        // $validator = $this->validateForm($request);
        // $data      = $this->albumPictureRepository->getByID($id);
        // if ($validator->passes() && !empty($data)) {
        //     $posts = $request->input();
        //     if ($fileName = $this->uploadFile($request)) {
        //         $posts['ap_image'] = $fileName;
        //     }

        //     $this->responseData['status'] = $this->albumPictureRepository->update($id, $posts);
        //     if ($this->responseData['status']) {
        //         $this->responseData['a_id']    = $posts['a_id'];
        //         $this->responseData['message'] = '修改成功';
        //     }
        // } else {
        //     $this->responseData['message'] = join('<br />', $validator->messages()->all());
        // }

        // return response()->json($this->responseData);
    }

    public function ajaxDelete(Request $request, $aId)
    {
        $album = $this->albumRepository->getByID($aId);
        if ($album) {
            $apId         = $request->input('ap_id');
            $albumPicture = $this->albumPictureRepository->getByID($apId);
            if ($albumPicture->a_id == $album->a_id) {
                $this->responseData['status'] = $this->albumPictureRepository->delete($apId, ['ap_status' => 2]);
                if ($this->responseData['status']) {
                    $this->responseData['message'] = '刪除成功';
                }
            } else {
                $this->responseData['message'] = '請確認刪除資料是否正確';
            }
        } else {
            $this->responseData['message'] = '請確認刪除資料是否正確';
        }

        return response()->json($this->responseData);
    }

    private function uploadFile(Request $request)
    {
        $posts = $request->input();
        $files = $request->file('ap_image');

        $uploadResult = [];
        if ($request->hasFile('ap_image')) {
            $this->destinationPath .= $posts['a_id'];

            foreach ($files as $file) {
                $fileName          = $file->getClientOriginalName();
                $posts['ap_image'] = $fileName;

                if (!is_dir($this->destinationPath)) {
                    mkdir($this->destinationPath);
                }
                $move = $file->move($this->destinationPath, $fileName);

                $imageData = [
                    'error' => ($move) ? 0 : 1,
                    'name'  => $posts['ap_image'],
                    'size'  => $file->getClientSize(),
                    'type'  => $file->getClientMimeType(),
                ];
                array_push($uploadResult, $imageData);

                $apId = $this->albumPictureRepository->insert($posts);
            }
            return $uploadResult;
        }

        return false;
    }

    private function notFound()
    {
        $message = array(
            'title'    => '錯誤',
            'caption'  => '錯誤',
            'message'  => '查無相簿資料',
            'url'      => '/admin/album',
            'linkName' => '返回相簿管理',
        );
        return view('admin.message', $message);
    }

    protected function validateForm(Request $request)
    {
        $rules = [
            'a_id'     => 'required',
            'ap_image' => 'required',
            // 'ap_status' => 'required',
        ];

        $attributes = [
            'a_id'      => '相簿',
            'ap_image'  => '相片',
            'ap_status' => '等級狀態',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        return $validator;
    }
}
