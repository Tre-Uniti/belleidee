<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intolerance extends Model
{
    protected $fillable = [
        'user_ruling',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
