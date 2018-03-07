<?php

namespace App\Repositories;

use App\Models\IndexSlide;
use Schema;

class IndexSlideRepository
{
    protected $model;

    public function __construct(IndexSlide $model)
    {
        $this->model = $model;
    }

    public function insert($datas)
    {
        $indexSlide            = new IndexSlide;
        $indexSlide->is_title  = $datas['is_title'] ?? '';
        $indexSlide->is_file   = $datas['is_file'] ?? '';
        $indexSlide->is_link   = $datas['is_link'] ?? '';
        $indexSlide->is_start  = $datas['is_start'] ?? '';
        $indexSlide->is_end    = $datas['is_end'] ?? '';
        $indexSlide->is_status = $datas['is_status'] ?? 1;
        $indexSlide->save();

        return $indexSlide->is_id;
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
        return IndexSlide::whereIn('is_id', $ids)->update($datas);
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
                    if (strpos($field, 'title') !== false) {
                        $query->where($field, "LIKE", '%' . $search . '%');
                    } else if ($search) {
                        $query->where($field, $search);
                    }
                }
            }
        }

        $query->where('is_status', '!=', 2);

        $lists = $query->paginate($rows);
        if ($queryData) {
            $lists->appends($queryData);
        }

        return $lists;
    }

}
