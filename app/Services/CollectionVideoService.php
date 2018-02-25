<?php

namespace App\Services;

use App\Repositories\CollectionVideoRepository;

class CollectionVideoService
{
	protected $repository;

    public function __construct(CollectionVideoRepository $repository)
    {
        $this->repository = $repository;
    }

    
    
}
