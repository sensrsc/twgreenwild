<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentReturn extends Model
{
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'payment_return';

    protected $primaryKey = 'pr_id';

    protected $fillable = ['pr_type', 'order_id', 'trade_no', 'post_data', 'return_code', 'return_msg', 'ip'];

    public function token()
    {
        return $this->hasOne('App\Models\OrderToken', 'order_id', 'order_id');
    }

}
