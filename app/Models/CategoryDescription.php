<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryDescription extends Model
{
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'category_description';

    protected $primaryKey = 'cd_id';

    protected $fillable = ['c_id', 'cd_title', 'cd_type', 'cd_status'];
}
