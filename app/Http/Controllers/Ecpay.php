<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EcpayService;
use Storage;

class Ecpay extends Controller
{
    protected $service;

    public function __construct(EcpayService $service)
    {
        $this->service = $service;
    }

    public function returnurl(Request $request)
    {
        $posts = $request->input();

        $fileName = $posts['MerchantTradeNo'] ?? time();
        
        $returnOk = $this->service->checkReturn($posts);
        if ($returnOk) {
            $posts['check_return_data'] = $returnOk;
            echo '1|OK';
        } else {
            $post['other'] = 'in other';
            echo $posts['RtnCode'] . '|' . $posts['RtnMsg'];
        }

        Storage::disk('local')->put('return_' . $fileName . '.txt', json_encode($posts));
    }

    public function infourl(Request $request)
    {
        $posts = $request->input();

        $fileName = $posts['MerchantTradeNo'] ?? time();
        
        $returnOk = $this->service->checkReturn($posts);
        if ($returnOk) {
            $posts['check_info_data'] = $returnOk;
            echo '1|OK';
        } else {
            $post['other'] = 'in info other';
            echo $posts['RtnCode'] . '|' . $posts['RtnMsg'];
        }

        Storage::disk('local')->put('info_' . $fileName . '.txt', json_encode($posts));
    }
}
