<?php

namespace App\Repositories;

use App\Models\SystemVariable;

class SystemVariableRepository
{
    protected $model;

    public function __construct(SystemVariable $model)
    {
        $this->model = $model;
    }

    public function insert($datas)
    {
        $systemVariable           = new SystemVariable;
        $systemVariable->sv_name  = $datas['sv_name'] ?? '';
        $systemVariable->sv_key   = $datas['sv_key'] ?? '';
        $systemVariable->sv_value = $datas['sv_value'] ?? '';
        $systemVariable->save();

        return $systemVariable->sv_id;
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
                if (strpos($field, 'name') !== false) {
                    $query->where($field, "LIKE", '%' . $search . '%');
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
