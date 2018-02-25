<?php

namespace App\Repositories;

use App\Models\CoachMeta;
use Schema;

class CoachMetaRepository
{
    protected $model;

    public function __construct(CoachMeta $model)
    {
        $this->model = $model;
    }

    public function insert($datas)
    {
        $coachMeta             = new CoachMeta;
        $coachMeta->cm_cid     = $datas['cm_cid'] ?? 0;
        $coachMeta->cm_type    = $datas['cm_type'] ?? 1;
        $coachMeta->cm_name    = $datas['cm_name'] ?? '';
        $coachMeta->cm_picture = $datas['cm_picture'] ?? '';
        $coachMeta->cm_status  = $datas['cm_status'] ?? 1;
        $coachMeta->save();

        return $coachMeta->cm_id;
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

    public function multiUpdate($cId, $ids, $datas)
    {
        return CoachMeta::whereIn('cm_id', $ids)->where('cm_cid', $cId)->update($datas);
    }

    public function delete($id, $datas)
    {
        $data = $this->getByID($id);
        if ($data) {
            $data->fill($datas);
            $isUpdate = $data->save();

            return $isUpdate;
        }
        return false;
    }

    public function getByID($id)
    {
        return $this->model->find($id);
    }

    public function pages($type, $cId, $rows, $queryData)
    {
        $query = $this->model->query();
        
        if ($queryData) {
            foreach ($queryData as $field => $search) {
                $isHave = Schema::hasColumn($this->model->getTable(), $field);
                if ($isHave) {
                    if (strpos($field, 'status') !== false) {
                        $query->where($field, $search);
                    } else if ($search) {
                        $query->where($field, "LIKE", '%' . $search . '%');
                    }
                }
            }
        }

        $query->where('cm_cid', $cId);
        $query->where('cm_type', $type);
        $query->where('cm_status', '!=', 2);

        $lists = $query->paginate($rows);
        if ($queryData) {
            $lists->appends($queryData);
        }

        return $lists;
    }

}
