<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarReserveOrder extends Model
{
    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'cro_created';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'cro_modified';

    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'car_reserve_order';

    protected $primaryKey = 'cro_id';

    protected $fillable = ['cro_type', 'cro_city', 'cro_district', 'cro_address', 'cro_car_model', 'cro_way', 'cro_adult', 'cro_children', 'cro_detail', 'cro_est_fee', 'cro_name', 'cro_telno', 'cro_email', 'order_id'];
}
