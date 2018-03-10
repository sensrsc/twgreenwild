<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'album';

    protected $primaryKey = 'a_id';

    protected $fillable = ['a_title', 'a_total_pic', 'c_id', 'a_cover', 'a_description', 'a_status', 'a_outside_link', 'a_date'];

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'c_id', 'c_id');
    }

    public function cover()
    {
        return $this->hasOne('App\Models\AlbumPicture', 'ap_id', 'a_cover');
    }
}
