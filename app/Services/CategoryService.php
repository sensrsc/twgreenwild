<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService extends BaseService
{
    public function __construct(CategoryRepository $repository)
    {
        parent::__construct($repository);
    }

    public function insertCategory($posts)
    {
    	$data = $this->insertData($posts);
    	if ($data) {
    		return $this->repository->processCategoryDescription($data->c_id, $posts);
    	}
    	
    	return false;
    }

    public function updateCategory($id, $posts)
    {
    	$result = $this->updateData($id, $posts);
    	if ($result) {
    		return $this->repository->processCategoryDescription($id, $posts);
    	}

    	return false;
    }

    public function getCategoryDescriptions($cId) 
    {
    	return $this->repository->getCategoryDescriptions($cId);
    }
}
