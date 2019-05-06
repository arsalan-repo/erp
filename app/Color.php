<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    public $timestamps = false;

    public function products(){
        return $this->hasMany('App\Product', 'code_id', 'id');
    }
}
