<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mesh extends Model
{
    public $table = "meshes";

    public function parent()
    {
        return $this->belongsTo('App\Section', 'parent_id');
    }
}
