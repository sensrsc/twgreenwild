<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivitiesNotes extends Model
{
	public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'activities_notes';

    protected $primaryKey = 'an_id';

    protected $fillable = ['an_name', 'an_body', 'an_cover', 'an_date', 'c_id', 'an_status'];
    
    public function picture()
    {
        return $this->hasOne('App\Models\AlbumPicture', 'ap_id', 'an_cover');
    }

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'c_id', 'c_id');
    }
}
