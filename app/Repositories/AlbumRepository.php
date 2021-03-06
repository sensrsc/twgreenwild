<?php

namespace App\Repositories;

use App\Models\Album;
use Schema;

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
        $album->a_date = $datas['a_date'] ?? '';
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

    public function multiUpdate($ids, $datas)
    {
        return Album::whereIn('a_id', $ids)->update($datas);
    }

    public function getByID($id)
    {
        return $this->model->find($id);
    }

    public function getByCategory($cId)
    {
        return $this->model->where('c_id', $cId)
                            ->where('a_status', 1)
                            ->get(['a_id as id', 'a_title as title', 'a_description']);
    }

    public function pages($rows, $queryData)
    {
        $query = $this->model->query();

        if ($queryData) {
            foreach ($queryData as $field => $search) {
                $isHave = Schema::hasColumn($this->model->getTable(), $field);
                if ($isHave) {
                    if (strpos($field, 'title') !== false) {
                        $query->where($field, "LIKE", '%'.$search.'%');
                    } else if ($search) {
                        $query->where($field, $search);
                    }
                }
            }
        }

        $query->where('a_status', '!=', 2);
        $query->orderBy('updated_at', 'desc');

        $lists = $query->paginate($rows);
        if ($queryData) {
            $lists->appends($queryData);    
        }
        
        return $lists;
    }

}
