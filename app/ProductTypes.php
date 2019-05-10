<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTypes extends Model
{
    protected $table = "product_type";
    public $timestamps = false;


    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function type()
    {
        return $this->belongsTo('App\ItemType');
    }
}
