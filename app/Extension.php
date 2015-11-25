<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extension extends Model
{
    protected $fillable = [
        'title',
        'body',
        'index',
        'belief_beacon',
        'index2',
        'extension_path',
        'post_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
