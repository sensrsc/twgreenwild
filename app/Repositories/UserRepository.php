<?php

namespace App\Repositories;

use App\Models\User;
use Schema;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function insert($datas)
    {
        $user             = new User;
        $user->u_account  = $datas['account'];
        $user->u_password = password_hash($datas['password'], PASSWORD_DEFAULT);
        $user->fb_id      = $datas['fb_id'] ?? '';
        $user->u_status   = $datas['u_status'] ?? 1;
        $user->save();

        return $user;
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

    public function getByID($id)
    {
        return $this->model->find($id);
    }

    public function getByAccount($account)
    {
        return $this->model->where('u_account', $account)
            ->first();
    }

    public function getByFbID($fbID)
    {
        return $this->model->where('fb_id', $fbID)
            ->first();
    }

    public function pages($rows, $queryData)
    {
        $query = $this->model->query();

        if ($queryData) {
            foreach ($queryData as $field => $search) {
                $isHave = Schema::hasColumn($this->model->getTable(), $field);
                if ($isHave) {
                    if (strpos($field, 'subject') !== false) {
                        $query->where($field, "LIKE", '%' . $search . '%');
                    } else if ($search) {
                        $query->where($field, $search);
                    }
                }
            }
        }

        $lists = $query->paginate($rows);
        if ($queryData) {
            $lists->appends($queryData);
        }

        return $lists;
    }
}
