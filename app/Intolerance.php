<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intolerance extends Model
{
    protected $fillable = [
        'user_ruling',
        'source_user',
];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function moderation()
    {
        return $this->hasOne('App\Moderation');
    }

    public function adjudication()
    {
        return $this->hasOne('App\Adjudication');
    }
}
