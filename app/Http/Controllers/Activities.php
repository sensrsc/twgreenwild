<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Activities extends Controller
{
    //

    public function index(Request $request, $id)
    {
    	
    	return view('front.activities');
    }
}
