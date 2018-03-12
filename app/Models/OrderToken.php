<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderToken extends Model
{
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'order_token';

    protected $primaryKey = 'ot_id';

    protected $fillable = ['o_id', 'order_id', 'token', 'return_code', 'return_message', 'check_value'];

    public function order()
    {
        return $this->hasOne('App\Models\Order', 'o_id', 'o_id');
    }

}
