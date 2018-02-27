<?php

namespace App\Repositories;

use App\Models\ActivitiesNotes;
use Schema;

class ActivitiesNotesRepository
{
    protected $model;

    public function __construct(ActivitiesNotes $model)
    {
        $this->model = $model;
    }

    public function insert($datas)
    {
        $activitiesNotes = new ActivitiesNotes;
        $activitiesNotes->c_id = $datas['c_id'];
        $activitiesNotes->an_name = $datas['an_name'] ?? '';
        $activitiesNotes->an_body = $datas['an_body'] ?? '';
        $activitiesNotes->an_cover = $datas['an_cover'] ?? 0;
        $activitiesNotes->an_date = $datas['an_date'] ?? '';
        $activitiesNotes->an_status = $datas['an_status'] ?? 1;
        $activitiesNotes->save();

        return $activitiesNotes->an_id;
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
        return ActivitiesNotes::whereIn('an_id', $ids)->update($datas);
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
                        $query->where($field, "LIKE", '%'.$search.'%');
                    } else if ($search) {
                        $query->where($field, $search);
                    }
                }
            }
        }

        $query->where('an_status', '!=', 2);

        $lists = $query->paginate($rows);
        if ($queryData) {
            $lists->appends($queryData);    
        }
        
        return $lists;
    }

}
