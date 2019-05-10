<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    public $timestamps = false;

    protected $appends = [
        'category_names',
        'type_names',
        'color_names'
    ];

    public function categories()
    {
        return $this->hasMany('App\ProductCategory', 'product_id');
    }

    public function getCategoryNamesAttribute()
    {
        $categories = $this->categories->all();

        return implode(', ', array_map(function ($cat) {
            return $cat->category->name;
        }, $categories));
    }

    public function types()
    {
        return $this->hasMany('App\ProductTypes', 'product_id');
    }

    public function getTypeNamesAttribute()
    {
        $types = $this->types->all();

        return implode(',', array_map(function ($type) {
            return $type->type->name;
        }, $types));
    }

    public function colors()
    {
        return $this->hasMany('App\ProductColors', 'product_id');
    }

    public function getColorNamesAttribute()
    {
        $colors = $this->colors->all();

        return implode(',', array_map(function ($color) {
            return $color->color->name;
        }, $colors));
    }
}
