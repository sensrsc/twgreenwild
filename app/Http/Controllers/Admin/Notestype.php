<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ActiviesNotesTypeRepository;
use Illuminate\Http\Request;

class Notestype extends Controller
{
    //
    protected $antRepository;
    protected $responseData;

    public function __construct(ActiviesNotesTypeRepository $repository)
    {
        $this->antRepository = $repository;
        $this->responseData  = [
            'status'  => false,
            'message' => '',
        ];
    }

    public function index(Request $request)
    {
        $queryData = $request->query();
        $lists     = $this->antRepository->pages(env('PRE_PAGE'), $queryData);

        return view('admin.notestype.list', compact('lists'));
    }
}
