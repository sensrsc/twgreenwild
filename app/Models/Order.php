<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'order';

    protected $primaryKey = 'o_id';

    protected $fillable = ['u_id', 'apply_date', 'adult_num', 'child_num', 'apply_num', 'apply_name', 'apply_gender', 'apply_phone', 'apply_address', 'apply_email', 'apply_memo', 'car_need', 'o_order_id', 't_id', 'total_price', 'o_detail', 'o_status', 'payment_type'];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'u_id', 'u_id');
    }

    public function tour()
    {
        return $this->hasOne('App\Models\Tour', 't_id', 't_id');
    }

    public function tokens()
    {
        return $this->hasMany('App\Models\OrderToken', 'o_id', 'o_id');
    }

    public function lastToken()
    {
        return $this->hasOne('App\Models\OrderToken', 'o_id', 'o_id')->where('return_code', 1)->latest();
    }

}
