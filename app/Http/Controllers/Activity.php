<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Activity extends Controller
{
    //

    public function index()
    {
    	return view('front.activity');
    }

}
