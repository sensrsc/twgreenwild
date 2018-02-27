<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumPicture extends Model
{
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'album_picture';

    protected $primaryKey = 'ap_id';

    protected $fillable = ['a_id', 'ap_image', 'ap_description', 'ap_status'];

    public function album()
    {
        return $this->hasOne('App\Models\Album', 'a_id', 'a_id');
    }

    public function getPicturePathAttribute()
    {
        return '/upload/picture/' . $this->a_id . '/' . $this->ap_image;
    }
}
