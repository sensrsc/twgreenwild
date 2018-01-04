<?php

namespace App\Repositories;

use App\Models\Admin;

class AdminRepository
{
    protected $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function getByID($id)
    {
        return $this->admin->find($id);
    }

    public function getByAccount($account)
    {
        return $this->admin->where('a_account', $account)
                            ->first();    
    }

    public function loginAdmin($account, $password)
    {
        return $this->admin->where('a_account', $account)
                            ->where('a_password', $password)
                            ->first();
    }

    public function pages($rows, $queryData)
    {
        $query = $this->admin->query();

        if ($queryData) {
            foreach ($queryData as $field => $search) {
                if ($search) {
                    $query->where($field, "LIKE", '%'.$search.'%');
                }
            }
        }

        return $query->paginate($rows);
    }
}
