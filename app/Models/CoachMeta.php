<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoachMeta extends Model
{
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'coach_meta';

    protected $primaryKey = 'cm_id';

    protected $fillable = ['cm_type', 'cm_cid', 'cm_name', 'cm_picture', 'cm_status'];

    public function coach()
    {
        return $this->hasOne('App\Models\Coach', 'c_id', 'cm_cid');
    }
}
