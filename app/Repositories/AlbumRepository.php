<?php

namespace App\Repositories;

use App\Models\Album;

class AlbumRepository
{
    protected $model;

    public function __construct(Album $model)
    {
        $this->model = $model;
    }

    public function insert($datas)
    {
        $album = new Album;
        $album->c_id = $datas['c_id'];
        $album->a_title = $datas['a_title'] ?? '';
        $album->a_description = $datas['a_description'] ?? '';
        $album->a_status = $datas['a_status'] ?? 1;
        $album->a_outside_link = $datas['a_outside_link'] ?? '';
        $album->save();

        return $album->a_id;
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
                if (strpos($field, 'title') !== false) {
                    $query->where($field, "LIKE", '%'.$search.'%');
                } else if ($search) {
                    $query->where($field, $search);
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
