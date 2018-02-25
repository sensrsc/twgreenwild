<?php

namespace App\Repositories;

use App\Models\CollectionVideo;
use Schema;

class CollectionVideoRepository
{
    protected $model;

    public function __construct(CollectionVideo $model)
    {
        $this->model = $model;
    }

    public function insert($datas)
    {
        $video = new CollectionVideo;
        $video->c_id = $datas['c_id'];
        $video->cv_name = $datas['cv_name'] ?? '';
        $video->cv_description = $datas['cv_description'] ?? '';
        $video->cv_status = $datas['cv_status'] ?? 1;
        $video->cv_youtube_link = $datas['cv_youtube_link'] ?? '';
        $video->cv_date = $datas['cv_date'] ?? '';
        $video->save();

        return $video->cv_id;
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
        return CollectionVideo::whereIn('cv_id', $ids)->update($datas);
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

        $query->where('cv_status', '!=', 2);

        $lists = $query->paginate($rows);
        if ($queryData) {
            $lists->appends($queryData);    
        }
        
        return $lists;
    }

}
