<?php

namespace App\Repositories;

use App\Models\OrderToken;
use Schema;

class OrderTokenRepository
{
    protected $model;

    public function __construct(OrderToken $model)
    {
        $this->model = $model;
    }

    public function insert($order, $datas)
    {
        $orderToken                 = new OrderToken;
        $orderToken->o_id           = $order->o_id;
        $orderToken->order_id       = $datas['MerchantTradeNo'];
        $orderToken->return_code    = $datas['RtnCode'];
        $orderToken->token          = $datas['SPToken'] ?? '';
        $orderToken->return_message = $datas['RtnMsg'] ?? '';
        $orderToken->check_value    = $datas['CheckMacValue'] ?? '';
        $orderToken->return_data    = json_encode($datas);
        $orderToken->save();

        return $orderToken;
    }

    public function update($id, $datas)
    {
        $data = $this->getByID($id);
        if ($data) {
            $data->fill($datas);
            return $data->save();
        }
        return false;
    }

    public function getByID($id)
    {
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

        $lists = $query->paginate($rows);
        if ($queryData) {
            $lists->appends($queryData);
        }

        return $lists;
    }

    public function getByOrderID($orderID)
    {
        return $this->model->where('order_id', $orderID)
            ->first();
    }

    public function getTokenOrderID($oID, $orderID)
    {
        $orderNum = $this->model->where('o_id', $oID)->count() + 1;

        $orderNum = str_pad($orderNum, 4, '0', STR_PAD_LEFT);

        return $orderID . $orderNum;
    }

    public function getOrderLastToken($oID, $paymentType)
    {
        $this->model->where('o_id', $oID)
            ->where('return_code', '1')
            ->orderBy('ot_id', 'desc');

        if ($paymentType != 2) {
            $this->model->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-10 minutes', time())));
        }

        return $this->model->first();
    }
}
