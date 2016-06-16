<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function sponsor()
    {
        return $this->belongsTo('App\Sponsor');
    }
}
