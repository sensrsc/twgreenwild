<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemVariable extends Model
{
    public function __construce()
    {
        parent::__construce();
    }

    protected $table = 'system_variable';

    protected $primaryKey = 'sv_id';

    protected $fillable = ['sv_name', 'sv_key', 'sv_value'];
}
