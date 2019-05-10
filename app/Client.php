<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $table = 'clients';
    public $timestamps = false;

    public function distributor()
    {
        return $this->belongsTo('App\User', 'distributor_id', 'id');
    }

}
