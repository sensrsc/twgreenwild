<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'coach';

    protected $primaryKey = 'c_id';

    protected $fillable = ['c_name', 'c_motto', 'c_avatar', 'c_specialty', 'c_seq', 'c_status'];

    // public function category()
    // {
    //     return $this->hasOne('App\Models\Category', 'c_id', 'c_id');
    // }
}
