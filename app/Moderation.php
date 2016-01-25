<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moderation extends Model
{
    protected $fillable = [
        'mod_ruling',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function intolerance()
    {
        return $this->belongsTo('App\Intolerance');
    }

    public function adjudication()
    {
        return $this->hasOne('App\Moderation');
    }
}
