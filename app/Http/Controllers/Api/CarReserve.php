<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CarReserveRepository;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;

class CarReserve extends Controller
{
    protected $carReserveRepository;

    public function __construct(CarReserveRepository $repository)
    {
        $this->carReserveRepository = $repository;
    }


    public function carmodel(Request $request)
    {
        $city = $request->get('city');
        $data = $this->carReserveRepository->getModelByCity($city)->toArray();
        $status = ($data)? true : false;
        return response()->json(
            compact('status', 'data'),
            200
        );
    }


    public function calculate(Request $request)
    {
        $type = $request->get('type');
        $city = $request->get('city');
        $model = $request->get('model');
        $district = $request->get('district');
        $price = $this->carReserveRepository->getReservePrice($type, $city, $model, $district);
        $status = ($price > 0)? true : false;
        return response()->json(
            compact('status', 'price'),
            200
        );
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $list = $this->categoryRepository->pages(env('PRE_PAGE'), $request->query());
        $list = new CategoryCollection($list);
        // $list = CategoryResource::collection($list);
        $message = '';
        return response()->json(
            compact('list', 'message'),
            200
        );
    }

}
