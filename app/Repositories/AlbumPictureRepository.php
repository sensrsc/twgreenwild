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

    public function getAlbumPicture($aId)
    {
        return AlbumPicture::where('a_id', $aId)
            ->where('ap_status', 1)
            ->get();
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
