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
        'post_path',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function elevation()
    {
        return $this->hasMany('App\Elevate');
    }

}
