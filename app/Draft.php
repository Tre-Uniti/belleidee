<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    protected $fillable = [
        'title',
        'body',
        'published_at',
        'index',
        'beacon_tag',
        'index2',
        'draft_path',
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
