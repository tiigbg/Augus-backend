<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function description()
    {
        return $this->hasOne('App\Text', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Object', 'parent_id');
    }
}
