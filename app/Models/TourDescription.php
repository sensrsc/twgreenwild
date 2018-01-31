<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourDescription extends Model
{
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'tour_description';

    protected $primaryKey = 'td_id';

    protected $fillable = ['t_id', 'cd_id', 'td_content', 'td_status'];

    public function cateDesc()
    {
        return $this->hasOne('App\Models\CategoryDescription', 'cd_id', 'cd_id');
    }
}
