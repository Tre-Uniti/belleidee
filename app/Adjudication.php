<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adjudication extends Model
{
    protected $fillable = [
        'admin_ruling',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function moderation()
    {
        return $this->belongsTo('App\Moderation');
    }

    public function intolerance()
    {
        return $this->belongsTo('App\Intolerance');
    }
}
