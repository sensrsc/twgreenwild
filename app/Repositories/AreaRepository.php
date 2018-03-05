<?php

namespace App\Repositories;

use App\Models\Area;

class AreaRepository
{
    protected $model;

    public function __construct(Area $model)
    {
        $this->model = $model;
    }

    public function insert($datas)
    {
        
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
                if (strpos($field, 'status') !== false) {
                    $query->where($field, $search);
                } else if ($search) {
                    $query->where($field, "LIKE", '%'.$search.'%');
                }
            }
        }

        $lists = $query->paginate($rows);
        if ($queryData) {
            $lists->appends($queryData);    
        }
        
        return $lists;
    }

    public function getAll($column = null)
    {
        return $this->model->where('area_id' , '!=', 5)->get($column);
    }

}
