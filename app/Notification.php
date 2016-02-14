<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'title',
        'source_user',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
