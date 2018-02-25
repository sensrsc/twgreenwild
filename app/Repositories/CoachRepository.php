<?php

namespace App\Repositories;

use App\Models\Coach;
use Schema;

class CoachRepository
{
    protected $model;

    public function __construct(Coach $model)
    {
        $this->model = $model;
    }

    public function insert($datas)
    {
        $coach = new Coach;
        $coach->c_name = $datas['c_name'] ?? '';
        $coach->c_motto = $datas['c_motto'] ?? '';
        $coach->c_avatar = $datas['c_avatar'] ?? '';
        $coach->c_specialty = $datas['c_specialty'] ?? '';
        $coach->c_seq = $datas['c_seq'] ?? 1;
        $coach->c_status = $datas['c_status'] ?? 1;
        $coach->save();

        return $coach->c_id;
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
        return Coach::whereIn('c_id', $ids)->update($datas);
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

        $query->where('c_status', '!=', 2);

        $lists = $query->paginate($rows);
        if ($queryData) {
            $lists->appends($queryData);    
        }
        
        return $lists;
    }

}
