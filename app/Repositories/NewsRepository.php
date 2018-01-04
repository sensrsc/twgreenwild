<?php

namespace App\Repositories;

use App\Models\News;

class NewsRepository extends BaseRepository
{
    public function __construct(News $model)
    {
        parent::__construct($model);
    }

    
}
