<?php

namespace App\Services;

use App\Models\CarReserve;
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
            'cro_adult'     => $posts['adult'] ?? 0,
            'cro_children'  => $posts['children'] ?? 0,
            'cro_city'      => $posts['city'] ?? '',
            'cro_district'  => $posts['district'] ?? '',
            'cro_address'   => $posts['address'] ?? '',
            'cro_car_model' => $posts['model'] ?? '',
            'cro_est_fee'   => $this->calculateFee($type, $posts),
        ];

        if ($type == 'airport') {
            $newPostsData['cro_way'] = $posts['way'] ?? 0;

            if ($posts['way'] == '去程' || $posts['way'] == '來回') {
                $detailData['go_adult']    = $posts['go_adult'] ?? '';
                $detailData['go_children'] = $posts['go_children'] ?? '';
                $detailData['airport_go']  = $posts['airport_go'] ?? '';
                $detailData['date_go']     = $posts['date_go_year'] . '-' . $posts['date_go_month'] . '-' . $posts
                    ['date_go_day'];
                $detailData['time_go'] = $posts['time_go'];
            }

            if ($posts['way'] == '回程' || $posts['way'] == '來回') {
                $detailData['back_adult']    = $posts['back_adult'] ?? '';
                $detailData['back_children'] = $posts['back_children'] ?? '';
                $detailData['airport_back']  = $posts['airport_back'] ?? '';
                $detailData['date_back']     = $posts['date_back_year'] . '-' . $posts['date_back_month'] . '-' . $posts
                    ['date_back_day'];
                $detailData['time_back'] = $posts['time_back'];
                $detailData['flight']    = $posts['flight'];
            }
        } else {
            $detailData['date'] = $posts['date_year'] . '-' . $posts['date_month'] . '-' . $posts
                ['date_day'];
            $detailData['time'] = $posts['time'];
        }

        $newPostsData['cro_detail'] = json_encode($detailData);

        return $newPostsData;
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

    public function sendEmail($datas)
    {
        $adminEmail = \App\Models\SystemVariable::where('sv_key', 'admin_email')->first();

        if ($adminEmail) {
            $emails = explode(',', $adminEmail['sv_value']);

            foreach ($emails as $email) {
                // Mail::send('emails.reserve_car', $datas, function ($m) use ($email) {
                //     $m->from('wnrsfnw@gmail.com', 'Your Application');

                //     $m->to($email)->subject('Your Reminder!');
                // });
            }

        }
    }

}
