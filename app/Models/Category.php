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

    protected $fillable = ['c_title', 'c_file', 'c_fee_body', 'c_issue_body', 'c_notice_body', 'c_cancel_body', 'c_status'];

    public function levels()
    {
    	return $this->hasMany('App\Models\CategoryLevel', 'c_id', 'c_id')->where('cl_status', 1);
    }
}
