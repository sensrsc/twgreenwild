<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarReserve extends Model
{
    //
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'car_reserve';

    protected $primaryKey = 'cr_id';

    protected $fillable = ['cr_type', 'cr_name', 'cr_model', 'cr_price'];

    public $timestamps = false;
}
