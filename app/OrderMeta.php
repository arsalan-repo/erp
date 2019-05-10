<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMeta extends Model
{
    protected $table = "order_meta";

    public function orders(){
        return $this->belongsTo('App\Order', 'order_id', 'id');
    }
}
