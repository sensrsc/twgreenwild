<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\OrderTokenRepository;
use App\Services\EcpayService;

class OrderTokenService
{
    protected $orderRepository;
    protected $orderTokenRepository;
    protected $paymentReturnRepository;
    protected $ecpayService;

    public function __construct(OrderRepository $repository, OrderTokenRepository $orderTokenRepository, EcpayService $ecpayService)
    {
        $this->orderRepository         = $repository;
        $this->orderTokenRepository    = $orderTokenRepository;
        $this->ecpayService            = $ecpayService;
    }

    public function getOrderToken($oID)
    {
        $order = $this->orderRepository->getByID($oID);

        if ($order && $order->o_status == 2) {
            $getEcpayToken = true;
            $tokenData     = $order->lastToken;
            if ($tokenData) {
                if ($order->payment_type == 2) {
                    $paymentData = $tokenData->payment;
                    if ($paymentData) {
                        return true;
                    }
                }

                if (strtotime($tokenData->created_at) > strtotime('-10 minutes', time())) {
                    $getEcpayToken = false;
                }
            }

            if ($getEcpayToken) {
                $returnUrl      = url('ecpay/returnurl');
                $paymentInfoUrl = url('ecpay/infourl');

                $orderData = [
                    'order_id'         => $this->orderTokenRepository->getTokenOrderID($order->o_id, $order->o_order_id),
                    'total_amount'     => $order->total_price,
                    'trade_desc'       => $order->tour->t_title,
                    'item_name'        => $order->tour->t_title . ' x ' . ($order->adult_num + $order->child_num),
                    'return_url'       => $returnUrl,
                    'payment_info_url' => $paymentInfoUrl,
                ];

                $result = $this->ecpayService->sptoken($orderData);
                if ($result) {
                    $tokenData = $this->orderTokenRepository->insert($order, $result);
                }
            }

            if ($tokenData) {
                return $tokenData->token;
            }
        }

        return false;
    }

    public function orderProcess($datas)
    {
        $orderToken = $this->orderTokenRepository->getByOrderID($datas['MerchantTradeNo']);

        if ($orderToken) {
            $order = $orderToken->order;
            if ($order) {
                if ($datas['RtnCode'] == '1') {
                    $order->o_status = 3;
                    $order->save();

                    $orderToken->pay_status = $datas['RtnCode'];
                    $orderToken->save();
                }
            }
        }
    }

    public function infoProcess($datas)
    {
        // $orderToken = $this->orderTokenRepository->getByOrderID($datas['MerchantTradeNo']);

    }

}
