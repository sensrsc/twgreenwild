<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'news';

    protected $primaryKey = 'n_id';

    protected $fillable = ['n_subject', 'n_content', 'n_status', 'n_top'];
}
