<?php

namespace App\Repositories;

use App\Models\CarReserve;
use Schema;
use DB;

class CarReserveRepository
{
    protected $model;

    public function __construct(CarReserve $model)
    {
        $this->model = $model;
    }

    public function insert($datas)
    {
        // $coach = new Coach;
        // $coach->c_name = $datas['c_name'] ?? '';
        // $coach->c_motto = $datas['c_motto'] ?? '';
        // $coach->c_avatar = $datas['c_avatar'] ?? '';
        // $coach->c_specialty = $datas['c_specialty'] ?? '';
        // $coach->c_seq = $datas['c_seq'] ?? 1;
        // $coach->c_status = $datas['c_status'] ?? 1;
        // $coach->save();

        // return $coach->c_id;
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
                        $query->where($field, "LIKE", '%'.$search.'%');
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

    public function getAllDayModel()
    {
        $models = $this->model->where('cr_type', '=', 'all_day')
                            ->get();
        return $models;
    }

    public function getModelByCity($city)
    {
        $models = $this->model->where('cr_type', '=', 'city')
                            ->where('cr_name', $city)
                            ->get();
        return $models;
    }

    public function getReservePrice($type, $city, $model, $district)
    {
        if ($type == 'all_day') {
            $data = $this->model->where('cr_type', '=', 'all_day')
                            ->where('cr_model', $model)
                            ->first();
            return $data->cr_price ?? false;
        }
        $data = $this->model->where('cr_type', 'city')
                            ->where('cr_name', $city)
                            ->where('cr_model', $model)
                            ->first();
        if ($data) {
            $totalPrice = $data->cr_price;
            $districtData = $this->model->where('cr_type', 'district')
                            ->where('cr_name', $district)
                            ->first();
            $totalPrice += $districtData->cr_price ?? 0;

            return $totalPrice;
        }

        return false;
    }


}
