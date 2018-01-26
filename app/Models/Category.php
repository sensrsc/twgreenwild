<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'category';

    protected $primaryKey = 'c_id';

    protected $fillable = ['c_title', 'c_file', 'c_status'];
}
