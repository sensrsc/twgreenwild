<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryLevel extends Model
{
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'category_level';

    protected $primaryKey = 'cl_id';

    protected $fillable = ['c_id', 'cl_title', 'cl_status'];
}
