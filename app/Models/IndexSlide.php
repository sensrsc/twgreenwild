<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndexSlide extends Model
{
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'index_slide';

    protected $primaryKey = 'is_id';

    protected $fillable = ['is_title', 'is_file', 'is_link', 'is_start', 'is_end', 'is_status'];

    public function getPicturePathAttribute()
    {
        return '/upload/slide/' . $this->is_file;
    }
}
