<?php

namespace App\Repositories;

use App\Models\Admin;

class AdminRepository
{
    protected $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }

    public function insertAdmin($posts)
    {
        $admin             = new Admin;
        $admin->a_account  = $posts['a_account'];
        $admin->a_password = password_hash($posts['a_password'], PASSWORD_DEFAULT);
        $admin->a_name     = $posts['a_name'] ?? '';
        $admin->a_email    = $posts['a_email'] ?? '';
        $admin->a_status   = $posts['a_status'];

        return $admin->save();
    }

    public function updateAdmin(Admin $admin, $posts)
    {
        $admin->a_account = $posts['a_account'];
        if (!empty($posts['a_password'])) {
            $admin->a_password = password_hash($posts['a_password'], PASSWORD_DEFAULT);
        }
        $admin->a_name   = $posts['a_name'] ?? '';
        $admin->a_email  = $posts['a_email'] ?? '';
        $admin->a_status = $posts['a_status'];

        return $admin->save();
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
                if (strpos($field, 'title') !== false) {
                    $query->where($field, "LIKE", '%'.$search.'%');
                } else if ($search) {
                    $query->where($field, $search);
                }
            }
        }

        $query->where('a_status', '!=', 2);

        $lists = $query->paginate($rows);
        if ($queryData) {
            $lists->appends($queryData);    
        }
        
        return $lists;
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
