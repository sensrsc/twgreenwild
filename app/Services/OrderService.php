<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\TourRepository;
use App\Repositories\UserRepository;

class OrderService
{
    protected $orderRepository;
    protected $userRepository;

    public function __construct(OrderRepository $repository, UserRepository $userRepository, TourRepository $tourRepository)
    {
        $this->orderRepository = $repository;
        $this->userRepository  = $userRepository;
        $this->tourRepository  = $tourRepository;
    }

    public function userFieldTransToOrderFeild($user)
    {
        $orderData                = new \stdClass;
        $orderData->apply_name    = $user->u_name ?? '';
        $orderData->apply_gender  = $user->u_gender ?? 0;
        $orderData->apply_phone   = $user->u_phone ?? '';
        $orderData->apply_address = $user->u_address ?? '';
        $orderData->apply_email   = $user->u_account ?? '';

        $orderData->o_detail                        = new \stdClass;
        $orderData->o_detail->apply_birthday        = $user->u_birthday ?? '';
        $orderData->o_detail->apply_height          = $user->u_height ?? '';
        $orderData->o_detail->apply_weight          = $user->u_weight ?? '';
        $orderData->o_detail->apply_foot            = $user->u_foot ?? '';
        $orderData->o_detail->apply_identity        = $user->u_identity ?? '';
        $orderData->o_detail->apply_emergency_name  = $user->u_emergency_name ?? '';
        $orderData->o_detail->apply_emergency_phone = $user->u_emergency_phone ?? '';

        return $orderData;
    }

    public function adminOrderDataProcess($datas)
    {
        // 帳號換u_id
        $user          = $this->userRepository->getByAccount($datas['account']);
        $datas['u_id'] = $user->u_id;
        // 訂單編號
        $datas['o_order_id'] = $this->orderRepository->getOrderID();
        // deatil資料
        $datas['o_detail'] = [];
        $totalPeople       = $datas['adult_num'] + $datas['child_num'];
        if ($totalPeople == 1) {
            $datas['o_detail']['apply_identity']        = $datas['apply_identity'];
            $datas['o_detail']['apply_birthday']        = $datas['apply_birthday'];
            $datas['o_detail']['apply_height']          = $datas['apply_height'];
            $datas['o_detail']['apply_weight']          = $datas['apply_weight'];
            $datas['o_detail']['apply_foot']            = $datas['apply_foot'];
            $datas['o_detail']['apply_emergency_name']  = $datas['apply_emergency_name'];
            $datas['o_detail']['apply_emergency_phone'] = $datas['apply_emergency_phone'];
        }
        return $datas;
    }

    public function notApplyDateCheck($datas)
    {
        $tour = $this->tourRepository->getByID($datas['t_id']);

        if ($tour) {
            if ($tour->not_accept_start && $tour->not_accept_end) {
                $applyTime = strtotime($datas['apply_date']);
                if (strtotime($tour->not_accept_start) <= $applyTime && $applyTime <= strtotime($tour->not_accept_end)) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }

    public function calculatePrice()
    {
        
    }

}
