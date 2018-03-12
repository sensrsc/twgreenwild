<?php

namespace App\Http\Controllers;

use App\Repositories\TourRepository;
use Illuminate\Http\Request;

class Activity extends Controller
{
    public function __construct(TourRepository $repository)
    {
        $this->tourRepository     = $repository;
    }

    public function index(Request $request, $id)
    {
    	$data = $this->tourRepository->getByID($id);

    	$tour = $data? $data->toArray() : [];
        $days = $data->days_apply ?? 0;
    	$activityDate = [
    		'apply_date' => date('Y-m-d', strtotime('+' . $days . 'days', time())),
    		'ready_date' => [],	
    	];

    	return view('front.activity', compact('activityDate', 'tour'));
    }

}
