<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function children()
    {
        return $this->hasMany('App\Section', 'parent_id');
    }

    public function titles()
    {
        return $this->hasMany('App\Text', 'parent_id')->where('type','=','title')->where('parent_type','=','section');
    }

    public function texts()
    {
        return $this->hasMany('App\Text', 'parent_id')->where('type','=','body')->where('parent_type','=','section');
    }

    public function audios()
    {
        return $this->hasMany('App\Audio', 'parent_id');
    }

    public function videos()
    {
        return $this->hasMany('App\Video', 'parent_id');
    }

    public function images()
    {
        return $this->hasMany('App\Image', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Section', 'parent_id');
    }
}
