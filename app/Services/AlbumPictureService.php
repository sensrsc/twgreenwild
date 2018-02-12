<?php

namespace App\Services;

use App\Repositories\AlbumPictureRepository;
use App\Repositories\AlbumRepository;

class AlbumPictureService
{
    protected $repository;
    protected $albumRepository;

    public function __construct(AlbumRepository $albumRepository, AlbumPictureRepository $repository)
    {
        $this->albumRepository = $albumRepository;
        $this->repository      = $repository;
    }

    public function multiDelete($aId, $apIds)
    {
        $album = $this->albumRepository->getById($aId);
        if ($album) {
            if (in_array($album->a_cover, $apIds)) {
                $album->a_cover = 0;
            }
            $num = $this->repository->multiUpdate($aId, $apIds, ['ap_status' => 2]);

            $album->a_total_pic -= $num;
            $album->save();
            return true;
        }
        return false;
    }

}
