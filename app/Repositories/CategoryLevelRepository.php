<?php

namespace App\Repositories;

use App\Models\CategoryLevel;

class CategoryLevelRepository
{
    protected $model;

    public function __construct(CategoryLevel $model)
    {
        $this->model = $model;
    }

    public function insert($datas)
    {
        $category = new CategoryLevel;
        $category->c_id = $datas['c_id'] ?? 0;
        $category->cl_title = $datas['cl_title'] ?? '';
        $category->cl_status = $datas['cl_status'] ?? 1;
        $category->save();

        return $category->cl_id;
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

    public function getCategoryLevel($cId)
    {
    	return CategoryDescription::where('c_id', $cId)
    								->where('cl_status', 1)
    								->get();
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

}
