<?php

namespace App\Services;

use App\Models\CarReserve;
use App\Models\CarReserveOrder;
use DB;
use Mail;

class CarReserveOrderService
{
    protected $model;

    public function __construct(CarReserve $model)
    {
        $this->model = $model;
    }

    public function postDataTrans($type, $posts)
    {
        $detailData   = [];
        $newPostsData = [
            'cro_type'      => $type,
            'cro_name'      => $posts['name'] ?? '',
            'cro_telno'     => $posts['phone'] ?? '',
            'cro_email'     => $posts['email'] ?? '',
            'cro_adult'     => $posts['adult'] ?? 0,
            'cro_children'  => $posts['children'] ?? 0,
            'cro_city'      => $posts['city'] ?? '',
            'cro_district'  => $posts['district'] ?? '',
            'cro_address'   => $posts['address'] ?? '',
            'cro_car_model' => $posts['model'] ?? '',
            'cro_est_fee'   => $this->calculateFee($type, $posts),
            'order_id'      => $this->getOrderID(),
        ];

        if ($type == 'airport') {
            $newPostsData['cro_way'] = $posts['way'] ?? 0;

            if ($posts['way'] == '去程' || $posts['way'] == '來回') {
                $dateGo                    = new \DateTime($posts['date_go_year'] . '-' . $posts['date_go_month'] . '-' . $posts['date_go_day']);
                $detailData['go_adult']    = $posts['go_adult'] ?? '';
                $detailData['go_children'] = $posts['go_children'] ?? '';
                $detailData['airport_go']  = $posts['airport_go'] ?? '';
                $detailData['date_go']     = $dateGo->format('Y-m-d');
                $detailData['time_go']     = $posts['time_go'];

                $newPostsData['cro_adult']    = $detailData['go_adult'];
                $newPostsData['cro_children'] = $detailData['go_children'];
            }

            if ($posts['way'] == '回程' || $posts['way'] == '來回') {
                $dateBack                    = new \DateTime($posts['date_back_year'] . '-' . $posts['date_back_month'] . '-' . $posts['date_back_day']);
                $detailData['back_adult']    = $posts['back_adult'] ?? '';
                $detailData['back_children'] = $posts['back_children'] ?? '';
                $detailData['airport_back']  = $posts['airport_back'] ?? '';
                $detailData['date_back']     = $dateBack->format('Y-m-d');
                $detailData['time_back']     = $posts['time_back'];
                $detailData['flight']        = $posts['flight'];

                if ($posts['way'] == '回程'){
                    $newPostsData['cro_adult']    = $detailData['back_adult'];
                    $newPostsData['cro_children'] = $detailData['back_children'];
                }
            }
        } else {
            $date               = new \DateTime($posts['date_year'] . '-' . $posts['date_month'] . '-' . $posts['date_day']);
            $detailData['date'] = $date->format('Y-m-d');
            $detailData['time'] = $posts['time'];
        }

        $newPostsData['cro_detail'] = $detailData;

        return $newPostsData;
    }

    public function getOrderID()
    {
        $ymd = date('Ymd');
        $num = (CarReserveOrder::where(DB::raw('date_format(cro_created, "%Y%m%d")'), $ymd)->count()) + 1;
        $num = str_pad($num, 4, '0', STR_PAD_LEFT);
        return $ymd . $num;
    }

    public function calculateFee($type, $posts)
    {
        $totalPrice = 0;

        if ($type == 'airport') {
            $car = $this->model->where('cr_type', 'city')
                ->where('cr_name', $posts['city'])
                ->where('cr_model', $posts['model'])
                ->first();
            $totalPrice = $car->cr_price;

            $other = $this->model->where('cr_type', 'district')
                ->where('cr_name', $posts['district'])
                ->first();
            if ($other) {
                $totalPrice += $other->cr_price;
            }

            if ($posts['way'] == '來回') {
                $totalPrice *= 2;
            }
        } else {
            $car = $this->model->where('cr_type', 'all_day')
                ->where('cr_model', $posts['model'])
                ->first();
            $totalPrice = $car->cr_price;
        }

        return $totalPrice;
    }

    public function sendEmail($data)
    {
        $adminEmail = \App\Models\SystemVariable::where('sv_key', 'admin_email')->first();

        $subject = '預約包車通知信';
        $this->send($data, $data['cro_email'], $subject);

        if ($adminEmail) {
            $emails = explode(',', $adminEmail['sv_value']);
            $subject = '【預約單：' . $data['order_id'] . '】';

            foreach ($emails as $email) {
                $this->send($data, trim($email), $subject);
            }
        }
    }

    protected function send($data, $email, $subject)
    {
        Mail::send('emails.reserve_car', ['data' => $data], function ($m) use ($email, $subject) {
            $m->from('wnrsfnw@gmail.com', '綠葉戶外');

            $m->to($email)->subject($subject);
        });
    }

}
