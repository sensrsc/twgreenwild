<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'area';

    protected $primaryKey = 'area_id';

    protected $fillable = ['area_name'];
}
