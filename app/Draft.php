<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    protected $fillable = [
        'title',
        'body',
        'published_at',
        'belief',
        'beacon_tag',
        'source',
        'draft_path',
        'caption',
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
