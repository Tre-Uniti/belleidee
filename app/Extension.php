<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extension extends Model
{
    protected $fillable = [
        'title',
        'body',
        'belief',
        'beacon_tag',
        'category',
        'extension_path',
        'post_id',
        'source_user',
        'extenception',
        'question_id',
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
