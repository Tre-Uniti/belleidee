<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BeaconModerator extends Model
{

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function beacon()
    {
        return $this->belongsTo('App\Beacon');
    }
}
