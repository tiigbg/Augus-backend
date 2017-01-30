<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function texts()
    {
        return $this->hasMany('App\Text', 'parent_id')->where('parent_type','=','image');
    }

    public function audios()
    {
        return $this->hasMany('App\Audio', 'parent_id')->where('parent_type','=','image');
    }

    public function parent()
    {
        return $this->belongsTo('App\Object', 'parent_id');
    }
}
