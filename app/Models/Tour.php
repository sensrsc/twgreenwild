<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'tour';

    protected $primaryKey = 't_id';

    protected $fillable = ['c_id', 'cl_id', 't_title', 't_description', 't_price', 't_weekday_price', 't_discount_price', 'a_id', 'area_id', 'min_people', 'full_people', 'days_apply', 'not_accept_start', 'not_accept_end', 'not_accept_reason', 'season_flag', 'hot_flag', 't_status'];

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'c_id', 'c_id');
    }

    public function area()
    {
        return $this->hasOne('App\Models\Area', 'area_id', 'area_id');   
    }

    public function descriptions()
    {
        return $this->hasMany('App\Models\TourDescription', 't_id', 't_id');
    }

    public function album()
    {
        return $this->hasOne('App\Models\Album', 'a_id', 'a_id')->where('a_status', 1);
    }
}
