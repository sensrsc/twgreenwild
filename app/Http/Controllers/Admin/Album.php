<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AlbumPictureRepository;
use App\Repositories\AlbumRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Validator;

class Album extends Controller
{
    protected $albumRepository;
    protected $categoryRepository;
    protected $responseData;

    public function __construct(AlbumRepository $repository, CategoryRepository $categoryRepository, AlbumPictureRepository $albumPictureRepository)
    {
        $this->albumRepository        = $repository;
        $this->categoryRepository     = $categoryRepository;
        $this->albumPictureRepository = $albumPictureRepository;
        $this->responseData           = [
            'status'  => false,
            'message' => '',
        ];
    }

    public function index(Request $request)
    {
        $queryData = $request->query();
        $lists     = $this->albumRepository->pages(env('PRE_PAGE'), $queryData);
        $categorys = $this->categoryRepository->getAll();

        return view('admin.album.list', compact('lists', 'categorys'));
    }

    public function add()
    {
        $categorys = $this->categoryRepository->getAll();
        return view('admin.album.detail', compact('categorys'));
    }

    public function detail($id)
    {
        $data = $this->albumRepository->getByID($id);
        if ($data) {
            $categorys = $this->categoryRepository->getAll();
            return view('admin.album.detail', compact('data', 'categorys'));
        }
        // error not found
        $message = array(
            'title'    => '錯誤',
            'caption'  => '錯誤',
            'message'  => '查無相簿資料',
            'url'      => '/admin/album',
            'linkName' => '反回相簿管理',
        );
        return view('admin.message', $message);
    }

    public function ajaxAdd(Request $request)
    {
        $validator = $this->validateForm($request);
        if ($validator->passes()) {
            $posts = $request->input();

            $cId                          = $this->albumRepository->insert($posts);
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
        $data      = $this->albumRepository->getByID($id);
        if ($validator->passes() && !empty($data)) {
            $posts = $request->input();

            $this->responseData['status'] = $this->albumRepository->update($id, $posts);
            if ($this->responseData['status']) {
                $this->responseData['message'] = '修改成功';
            }
        } else {
            $this->responseData['message'] = join('<br />', $validator->messages()->all());
        }

        return response()->json($this->responseData);
    }

    public function ajaxCover(Request $request, $id)
    {
        $album = $this->albumRepository->getByID($id);
        if ($album) {
            $apId         = $request->input('ap_id');
            $albumPicture = $this->albumPictureRepository->getByID($apId);

            if ($albumPicture->a_id == $album->a_id) {
                $this->responseData['status'] = $this->albumRepository->update($id, ['a_cover' => $apId]);
                if ($this->responseData['status']) {
                    $this->responseData['message'] = '設定封面成功';
                }
            } else {
                $this->responseData['message'] = '請確認資料是否正確';
            }
        } else {
            $this->responseData['message'] = '請確認資料是否正確';
        }

        return response()->json($this->responseData);
    }

    public function ajaxDelete(Request $request)
    {
        $aIds   = explode(',', $request->input('a_id'));
        if ($aIds) {
            $this->responseData['status'] = $this->albumRepository->multiUpdate($aIds, ['a_status' => 2]);
            if ($this->responseData['status']) {
                $this->responseData['message'] = '刪除成功';
            }
        } else {
            $this->responseData['message'] = '請確認資料是否正確';
        }

        return response()->json($this->responseData);
    }

    public function ajaxCategoryAlbum($cId)
    {
        $albums = $this->albumRepository->getByCategory($cId);
        if ($albums) {
            $this->responseData['status'] = ($albums) ? true : false;
            if ($this->responseData['status']) {
                $this->responseData['message'] = '成功';
                $this->responseData['datas']   = $albums;
            }
        } else {
            $this->responseData['message'] = join('<br />', $validator->messages()->all());
        }

        return response()->json($this->responseData);
    }

    protected function validateForm(Request $request)
    {
        $rules = [
            'a_title'  => 'required|max:50',
            'c_id'     => 'required',
            'a_status' => 'required',
            'a_date'   => 'required|date|date_format:"Y-m-d"',
        ];

        if ($request->input('a_outside_link')) {
            $rules['a_outside_link'] = 'url';
        }

        $attributes = [
            'a_title'        => '相簿名稱',
            'c_id'           => '行程分類',
            'a_status'       => '相簿狀態',
            'a_outside_link' => '外部連結',
            'a_date'         => '相簿日期',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        return $validator;
    }

}
