<?php

namespace App\Repositories;

use App\Models\PaymentReturn;
use Request;
use Schema;

class PaymentReturnRepository
{
    protected $model;

    public function __construct(PaymentReturn $model)
    {
        $this->model = $model;
    }

    public function insert($type, $datas)
    {
        $paymentReturn              = new PaymentReturn;
        $paymentReturn->pr_type     = $type ?? 1;
        $paymentReturn->order_id    = $datas['MerchantTradeNo'];
        $paymentReturn->trade_no    = $datas['TradeNo'] ?? '';
        $paymentReturn->post_data   = json_encode($datas);
        $paymentReturn->return_code = $datas['RtnCode'];
        $paymentReturn->return_msg  = $datas['RtnMsg'];
        $paymentReturn->ip          = Request::ip();
        $paymentReturn->save();

        return $paymentReturn;
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
}
