<?php

namespace App\Repositories;

use App\Models\CarReserveOrder;
use Schema;

class CarReserveOrderRepository
{
    protected $model;

    public function __construct(CarReserveOrder $model)
    {
        $this->model = $model;
    }

    public function insert($datas)
    {
        $cro                = new CarReserveOrder;
        $cro->cro_type      = $datas['cro_type'] ?? '';
        $cro->cro_city      = $datas['cro_city'] ?? '';
        $cro->cro_district  = $datas['cro_district'] ?? '';
        $cro->cro_address   = $datas['cro_address'] ?? '';
        $cro->cro_car_model = $datas['cro_car_model'] ?? '';
        $cro->cro_way       = $datas['cro_way'] ?? 1;
        $cro->cro_adult     = $datas['cro_adult'] ?? 1;
        $cro->cro_children  = $datas['cro_children'] ?? 1;
        $cro->cro_detail    = json_encode($datas['cro_detail']) ?? '';
        $cro->cro_est_fee   = $datas['cro_est_fee'] ?? 1;
        $cro->cro_name      = $datas['cro_name'] ?? '';
        $cro->cro_telno     = $datas['cro_telno'] ?? '';
        $cro->cro_email     = $datas['cro_email'] ?? '';
        $cro->order_id      = $datas['order_id'] ?? '';
        $cro->save();

        return $cro->cro_id;
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
                    if (strpos($field, 'name') !== false) {
                        $query->where($field, "LIKE", '%' . $search . '%');
                    } else if ($search) {
                        $query->where($field, $search);
                    }
                }
            }
        }

        $query->orderBy('cro_created', 'desc');

        $lists = $query->paginate($rows);
        if ($queryData) {
            $lists->appends($queryData);
        }

        return $lists;
    }

}
