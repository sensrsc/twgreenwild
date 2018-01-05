<?php

namespace App\Repositories;

use App\Models\Admin;

class AdminRepository extends BaseRepository
{

    public function __construct(Admin $model)
    {
        parent::__construct($model);
    }

    public function getByAccount($account)
    {
        return $this->model->where('a_account', $account)
                            ->first();    
    }

    public function loginAdmin($account, $password)
    {
        return $this->model->where('a_account', $account)
                            ->where('a_password', $password)
                            ->first();
    }
}
