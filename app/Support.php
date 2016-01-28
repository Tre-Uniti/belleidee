<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $fillable = [
        'request',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
