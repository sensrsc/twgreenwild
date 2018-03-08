<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CarReserveOrderRepository;
use Illuminate\Http\Request;

class ReserveOrder extends Controller
{
    protected $adminRepository;
    protected $responseData;

    public function __construct(CarReserveOrderRepository $repository)
    {
        $this->carReserveOrderRepository = $repository;
        $this->responseData    = [
            'status'  => false,
            'message' => '',
        ];
    }

    public function index(Request $request)
    {
        $queryData = $request->query();
        $lists     = $this->carReserveOrderRepository->pages(env('PRE_PAGE'), $queryData);

        return view('admin.reserve_order.list', compact('lists'));
    }

    public function info(Request $request, $id)
    {
        $data = $this->carReserveOrderRepository->getByID($id);
        if ($data) {
            return view('admin.reserve_order.info', compact('data'));
        }
        $message = array(
            'title'    => '錯誤',
            'caption'  => '錯誤',
            'message'  => '查無預約叫車資料',
            'url'      => '/admin/reserveorder',
            'linkName' => '反回預約叫車管理',
        );
        return view('admin.message', $message);
    }

}
