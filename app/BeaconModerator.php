<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BeaconModerator extends Model
{

    protected $fillable =
    [
       'user_id',
       'beacon_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function beacon()
    {
        return $this->belongsTo('App\Beacon');
    }
}
