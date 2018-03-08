<?php

namespace App\Http\Controllers;

use App\Repositories\CarReserveOrderRepository;
use App\Repositories\CarReserveRepository;
use App\Services\CarReserveOrderService;
use Illuminate\Http\Request;
use Validator;

class Reserve extends Controller
{
    protected $carReserveRepository;
    protected $carReserveOrderRepository;
    protected $carReserveOrderService;

    public function __construct(CarReserveRepository $repository, CarReserveOrderRepository $carReserveOrderRepository, CarReserveOrderService $carReserveOrderService)
    {
        $this->carReserveRepository      = $repository;
        $this->carReserveOrderRepository = $carReserveOrderRepository;
        $this->carReserveOrderService    = $carReserveOrderService;
    }

    public function index()
    {
        $models = $this->carReserveRepository->getAllDayModel();
        return view('front/reserve_car', compact('models'));
    }

    public function createReserve(Request $request)
    {
        $status  = false;
        $message = '預約已送出，我們將會盡速與您聯絡';

        $validator = $this->validateForm($request);
        $type      = $request->input('type');
        $posts     = $request->input();

        if ($validator->passes()) {
            $insertData = $this->carReserveOrderService->postDataTrans($type, $posts);
            $cro_id     = $this->carReserveOrderRepository->insert($insertData);
            $status     = ($cro_id > 0) ? true : false;
            if ($status === false) {
                $message = '預約發生錯誤';
            } else {
                $this->carReserveOrderService->sendEmail($posts);
            }
        } else {
            $message = join('<br />', $validator->messages()->all());
        }

        return response()->json(compact('status', 'message'));
    }

    protected function validateForm(Request $request)
    {
        $rules = [
            'model'    => 'required',
            'city'     => 'required',
            'district' => 'required',
            'type'     => 'required',
        ];

        $attributes = [
            'model'    => '車型',
            'city'     => '縣市',
            'district' => '行政區',
            'type'     => '類型',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        return $validator;
    }

}
