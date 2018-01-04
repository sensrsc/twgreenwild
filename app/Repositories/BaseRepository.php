<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    public $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function insertData($datas)
    {
        $this->model->fill($datas);

        return $this->model->save();
    }

    public function updateData($id, $datas)
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

        return $query->paginate($rows);
    }
}
