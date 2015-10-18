<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'published_at',
        'index',
        'belief_beacon',
        'index2',
        'user_id',
        'published_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
