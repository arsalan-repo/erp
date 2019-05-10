<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductColors extends Model
{
    protected $table = "product_color";
    public $timestamps = false;


    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function color()
    {
        return $this->belongsTo('App\Color');
    }
}
