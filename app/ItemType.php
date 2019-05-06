<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    public $timestamps = false;
    protected $table = "types";

    public function product(){
        return $this->hasMany('App\Product', 'sub_category_id', 'id');
    }
}
