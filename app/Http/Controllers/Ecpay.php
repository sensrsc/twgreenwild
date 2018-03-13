<?php

namespace App\Http\Controllers;

use App\Repositories\PaymentReturnRepository;
use App\Services\EcpayService;
use App\Services\OrderTokenService;
use Illuminate\Http\Request;
use Storage;

class Ecpay extends Controller
{
    protected $service;
    protected $orderTokenService;
    protected $paymentReturnRepository;

    public function __construct(PaymentReturnRepository $paymentReturnRepository, EcpayService $service, OrderTokenService $orderTokenService)
    {
        $this->paymentReturnRepository = $paymentReturnRepository;
        $this->service                 = $service;
        $this->orderTokenService       = $orderTokenService;
    }

    public function returnurl(Request $request)
    {
        $posts = $request->input();

        if ($posts) {

            $returnOk = $this->service->checkReturn($posts);
            if ($returnOk) {
                $this->orderTokenService->orderProcess($posts);

                echo '1|OK';
            } else {

                echo $posts['RtnCode'] . '|' . $posts['RtnMsg'];
            }

            $this->paymentReturnRepository->insert(1, $posts);

        }

        $fileName = $posts['MerchantTradeNo'] ?? time();
        Storage::disk('local')->put('return_' . $fileName . '.txt', json_encode($posts));
    }

    public function infourl(Request $request)
    {
        $posts = $request->input();

        if ($posts) {

            $returnOk = $this->service->checkReturn($posts);
            if ($returnOk) {

                echo '1|OK';
            } else {

                echo $posts['RtnCode'] . '|' . $posts['RtnMsg'];
            }

            $this->paymentReturnRepository->insert(2, $posts);

        }

        $fileName = $posts['MerchantTradeNo'] ?? time();
        Storage::disk('local')->put('info_' . $fileName . '.txt', json_encode($posts));
    }
}
