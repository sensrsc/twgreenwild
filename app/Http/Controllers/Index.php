<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TourRepository;

class Index extends Controller
{
    protected $tourRepository;

	public function __construct(TourRepository $repository)
    {
        $this->tourRepository = $repository;
    }

    public function index()
    {
    	$hotActivities = $this->tourRepository->getByRecommendJoin('hot');
    	$seasonActivities = $this->tourRepository->getByRecommendJoin('season');
    	
    	return view('front/home', compact('hotActivities', 'seasonActivities'));
    }
}
