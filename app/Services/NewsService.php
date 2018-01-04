<?php

namespace App\Services;

use App\Repositories\NewsRepository;

class NewsService extends BaseService
{
    public function __construct(NewsRepository $repository)
    {
        parent::__construct($repository);
    }

    
}
