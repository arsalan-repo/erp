<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";

    public $timestamps = true;

    public function metas()
    {
        return $this->hasMany('App\OrderMeta', 'order_id', 'id');
    }

    public function get_metas($key, $default = true)
    {
        $row = $this->metas->where('key', $key)->first();
        $value = $default;

        if ($row) {
            $value = $row->value;
        }

        return $value;
    }

}
