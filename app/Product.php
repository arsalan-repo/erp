<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    public $timestamps = false;

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function color(){
        return $this->belongsTo('App\Color', 'code_id', 'id');
    }

    public function sub_category(){
        return $this->belongsTo('App\ItemType', 'sub_category_id', 'id');
    }

}
