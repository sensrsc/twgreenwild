<?php

namespace App\Repositories;

use App\Models\News;
use Schema;

class NewsRepository
{
    protected $model;

    public function __construct(News $model)
    {
        $this->model = $model;
    }

    public function insert($datas)
    {
        $news            = new News;
        $news->n_subject = $datas['n_subject'] ?? '';
        $news->n_content = $datas['n_content'] ?? '';
        $news->n_status  = $datas['n_status'] ?? 1;
        $news->n_top     = $datas['n_top'] ?? 2;
        $news->save();

        return $news->n_id;
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
                    if (strpos($field, 'subject') !== false) {
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
