<?php

namespace App\Repositories;

use App\Models\AlbumPicture;

class AlbumPictureRepository
{
    protected $model;

    public function __construct(AlbumPicture $model)
    {
        $this->model = $model;
    }

    public function insert($datas)
    {
        $albumPicture                 = new AlbumPicture;
        $albumPicture->a_id           = $datas['a_id'] ?? 0;
        $albumPicture->ap_image       = $datas['ap_image'] ?? '';
        $albumPicture->ap_description = $datas['ap_description'] ?? '';
        $albumPicture->ap_status      = $datas['ap_status'] ?? 1;
        $albumPicture->save();

        $albumPicture->album->a_total_pic += 1;
        $albumPicture->album->save();

        return $albumPicture->ap_id;
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

    public function multiUpdate($aId, $ids, $datas)
    {
        return AlbumPicture::whereIn('ap_id', $ids)->where('a_id', $aId)->update($datas);
    }

    public function delete($id, $datas)
    {
        $data = $this->getByID($id);
        if ($data) {
            $data->fill($datas);
            $isUpdate = $data->save();

            if ($id == $data->album->a_cover) {
                $data->album->a_cover = 0;
            }
            $data->album->a_total_pic -= 1;
            $data->album->save();

            return $isUpdate;
        }
        return false;
    }

    public function getAlbumPicture($aId)
    {
        return AlbumPicture::where('a_id', $aId)
            ->where('ap_status', 1)
            ->get(['ap_id as id', 'ap_image as title', 'ap_description']);
    }

    public function getByID($id)
    {
        return $this->model->find($id);
    }

    public function pages($rows, $queryData)
    {
        $query = $this->model->query();
        unset($queryData['page']);
        if ($queryData) {
            foreach ($queryData as $field => $search) {
                if (strpos($field, 'status') !== false) {
                    $query->where($field, $search);
                } else if ($search) {
                    $query->where($field, "LIKE", '%' . $search . '%');
                }
            }
        }

        $query->where('ap_status', '!=', 2);

        $lists = $query->paginate($rows);
        if ($queryData) {
            $lists->appends($queryData);
        }

        return $lists;
    }

}
