<?php

namespace App\Services;

class BaseService
{
    public $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function insertData($datas)
    {
        return $this->repository->insertData($datas);        
    }

    public function updateData($id, $datas)
    {
        return $this->repository->updateData($id, $datas);
    }

    public function pages($rows = 10, $queryData)
    {
        unset($queryData['page']);
        $lists = $this->repository->pages($rows, $queryData);
        if ($queryData) {
            $lists->appends($queryData);    
        }
        
        return $lists;
    }
    
    public function getByID($id)
    {
        return $this->repository->getByID($id);
    }

}
