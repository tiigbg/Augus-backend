<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signlanguage extends Model
{
    public function parent()
    {
        return $this->belongsTo('App\Section', 'parent_id');
    }
}
