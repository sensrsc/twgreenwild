<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\TourRepository;
use Illuminate\Http\Request;

class Activities extends Controller
{
    protected $tourRepository;

    public function __construct(TourRepository $repository, CategoryRepository $categoryRepository)
    {
        $this->tourRepository     = $repository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request, $id)
    {
        $category      = $this->categoryRepository->getById($id);
        $categoryTitle = $category->c_title ?? '';
        $activities    = $this->tourRepository->getByCategoryJoin($id);

        return view('front.activities', compact('activities', 'categoryTitle'));
    }
}
