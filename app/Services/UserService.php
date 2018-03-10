<?php

namespace App\Services;

use App\Models\User;
use Request;

class UserService
{
    public function __construct()
    {

    }

    public function dataTrans($datas)
    {
        $birthday = null;
        if (isset($datas['year']) && isset($datas['month']) && isset($datas['day'])) {
            $date = new \DateTime($datas['year'] . '-' . $datas['month'] . '-' . $datas['day']);
            $birthday = $date->format('Y-m-d');
        }

        $newData = [
            'u_name'            => $datas['name'] ?? '',
            'u_phone'           => $datas['phone'] ?? '',
            'u_identity'        => $datas['identity'] ?? '',
            'u_gender'          => $datas['gender'] ?? 0,
            'u_birthday'        => $birthday,
            'u_height'          => $datas['height'] ?? '',
            'u_weight'          => $datas['weight'] ?? '',
            'u_foot'            => $datas['foot'] ?? '',
            'u_emergency_name'  => $datas['emergency_name'] ?? '',
            'u_emergency_phone' => $datas['emergency_phone'] ?? '',
            'u_address'         => $datas['address'] ?? '',
        ];

        return $newData;
    }

    public function checkLogin(User $user, $account, $password)
    {
        if (!empty($user) && $user->u_status == 1 &&
            password_verify($password, $user->u_password)) {

            return true;
        }
        return false;
    }

    public function checkFacebookLogin(User $user)
    {
        if (!empty($user) && $user->u_status == 1) {
            return true;
        }
        return false;
    }

    public function login(User $user)
    {
        if (!empty($user)) {
            $user->ip         = Request::ip();
            $user->last_login = date('Y-m-d H:i:s');
            $user->save();

            session()->put('user', $user);

            return true;
        }
        return false;
    }

}
