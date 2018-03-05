<?php

namespace App\Repositories;

use App\Models\Category;
use Schema;

class CategoryRepository
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function insert($datas)
    {
        $category                = new Category;
        $category->c_title       = $datas['c_title'] ?? '';
        $category->c_fee_body    = $datas['c_fee_body'] ?? '';
        $category->c_issue_body  = $datas['c_issue_body'] ?? '';
        $category->c_notice_body = $datas['c_notice_body'] ?? '';
        $category->c_cancel_body = $datas['c_cancel_body'] ?? '';
        $category->c_file        = $datas['c_file'] ?? '';
        $category->c_status      = $datas['c_status'] ?? 1;
        $category->save();

        return $category->c_id;
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
                    if (strpos($field, 'title') !== false) {
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

    public function getAll($columns = null)
    {
        return $this->model->where('c_status', 1)
            ->get($columns);
    }

    public function getAllWithLevel($columns = null)
    {
        return $this->model->where('c_status', 1)
            ->with('levels')
            ->get($columns);
    }

}
