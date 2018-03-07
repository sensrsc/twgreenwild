<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CarReserveOrderRepository;
use App\Repositories\CarReserveRepository;
use Validator;

class Reserve extends Controller
{
    protected $carReserveRepository;

    public function __construct(CarReserveRepository $repository, CarReserveOrderRepository $carReserveOrderRepository)
    {
        $this->carReserveRepository      = $repository;
        $this->carReserveOrderRepository = $carReserveOrderRepository;
    }

    public function index()
    {
        $models = $this->carReserveRepository->getAllDayModel();
        return view('front/reserve_car', compact('models'));
    }

    public function createReserve(Request $request)
    {
        $validator = $this->validateForm($request);
        $posts = $request->input();
        if ($validator->passes()){

        }
    }

    protected function validateForm(Request $request)
    {
        $rules = [
            'is_title' => 'required|max:255',
            'is_file'  => 'required',
            'is_link'  => 'url',
            'is_start' => 'required|date_format:Y-m-d',
            'is_end'   => 'required|date_format:Y-m-d||after:is_start',
        ];

        $attributes = [
            'is_title' => '輪播名稱',
            'is_file'  => '輪播圖',
            'is_link'  => '輪播連結',
            'is_start' => '輪播開始日',
            'is_end'   => '輪播結束日',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        return $validator;
    }

}
