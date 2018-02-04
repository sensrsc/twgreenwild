<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class Index extends Controller
{
    //
    public function index()
    {
    	// var_dump(session()->get('admin')->a_account);
    	return view('admin.index');
    }

    public function test()
    {
    	// $desc = [];
    	// $a = view('admin.tour.description', ['data' => $desc])->__toString();
    	// var_dump($a);

        $news = News::find(2);  
        echo $news->n_content;

    }
}
