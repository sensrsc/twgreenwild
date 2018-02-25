<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionVideo extends Model
{
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'collection_video';

    protected $primaryKey = 'cv_id';

    protected $fillable = ['c_id', 'cv_name', 'cv_youtube_link', 'cv_description', 'cv_date', 'cv_status'];

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'c_id', 'c_id');
    }
}
