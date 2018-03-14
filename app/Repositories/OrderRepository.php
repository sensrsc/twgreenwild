<?php

namespace App\Repositories;

use App\Models\Order;
use Schema;

class OrderRepository
{
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function insert($datas)
    {
        $order                = new Order;
        $order->u_id          = $datas['u_id'];
        $order->apply_date    = $datas['apply_date'];
        $order->adult_num     = $datas['adult_num'] ?? 0;
        $order->child_num     = $datas['child_num'] ?? 0;
        $order->apply_name    = $datas['apply_name'];
        $order->apply_gender  = $datas['apply_gender'];
        $order->apply_phone   = $datas['apply_phone'];
        $order->apply_address = $datas['apply_address'];
        $order->apply_email   = $datas['apply_email'];
        $order->apply_memo    = $datas['apply_memo'] ?? '';
        $order->car_need      = $datas['car_need'] ?? 0;
        $order->o_order_id    = $datas['o_order_id'];
        $order->t_id          = $datas['t_id'];
        $order->total_price   = $datas['total_price'];
        $order->o_detail      = json_encode($datas['o_detail']);
        $order->o_status      = $datas['o_status'] ?? 0;
        $order->payment_type  = $datas['payment_type'] ?? 1;
        $order->save();

        if ($order->user) {
            $user = $order->user;
            if (!$user->u_name) {
                $user->u_name = $datas['apply_name'];
            }
            if (!$user->u_gender) {
                $user->u_gender = $datas['apply_gender'];
            }
            if (!$user->apply_phone) {
                $user->u_phone = $datas['apply_phone'];
            }
            if (!$user->u_address) {
                $user->u_address = $datas['apply_address'];
            }
            if (!$user->u_height && isset($datas['o_detail']['apply_height'])) {
                $user->u_height = $datas['o_detail']['apply_height'];
            }
            if (!$user->u_weight && isset($datas['o_detail']['apply_weight'])) {
                $user->u_weight = $datas['o_detail']['apply_weight'];
            }
            if (!$user->u_foot && isset($datas['o_detail']['apply_foot'])) {
                $user->u_foot = $datas['o_detail']['apply_foot'];
            }
            if (!$user->u_birthday && isset($datas['o_detail']['apply_birthday'])) {
                $user->u_birthday = $datas['o_detail']['apply_birthday'];
            }
            if (!$user->u_identity && isset($datas['o_detail']['apply_identity'])) {
                $user->u_identity = $datas['o_detail']['apply_identity'];
            }
            if (!$user->u_emergency_name && isset($datas['o_detail']['apply_emergency_name'])) {
                $user->u_emergency_name = $datas['o_detail']['apply_emergency_name'];
            }
            if (!$user->u_emergency_phone && isset($datas['o_detail']['apply_emergency_phone'])) {
                $user->u_emergency_phone = $datas['o_detail']['apply_emergency_phone'];
            }
            $user->save();
        }

        return $order->o_id;
    }

    public function update($id, $datas)
    {
        $data = $this->getByID($id);
        if ($data) {
            $datas['o_detail'] = json_encode($datas['o_detail']);
            $data->fill($datas);
            return $data->save();
        }
        return false;
    }

    public function getByID($id)
    {
        if (session()->has('user')) {
            return $this->model->where('u_id', session()->get('user')->u_id)->find($id);
        }
        return $this->model->find($id);
    }

    public function pages($rows, $queryData)
    {
        $query = $this->model->query();
        if ($queryData) {
            foreach ($queryData as $field => $search) {
                $isHave = Schema::hasColumn($this->model->getTable(), $field);
                if ($isHave) {
                    if (strpos($field, 'status') !== false) {
                        $query->where($field, "LIKE", '%' . $search . '%');
                    } else if ($search) {
                        $query->where($field, $search);
                    }
                }
            }
        }

        if (session()->has('user')) {
            $query->where('u_id', session()->get('user')->u_id);
        }

        $query->orderBy('o_id', 'desc');

        $lists = $query->paginate($rows);
        if ($queryData) {
            $lists->appends($queryData);
        }

        return $lists;
    }

    public function getOrderID()
    {
        $orderID = date('Ymd') . rand(1000000, 9999999);
        $order   = $this->model->where('o_order_id', $orderID)->first();
        if ($order) {
            return $this->getOrderID();
        }
        return $orderID;
    }
}
