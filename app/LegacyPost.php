<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LegacyPost extends Model
{
    protected $fillable = [
        'title',
        'belief',
        'body',
        'caption',
        'source_path',
        'original_source_path',

    ];

    public function legacy()
    {
        return $this->belongsTo('App\Legacy');
    }

    public function elevation()
    {
        return $this->hasMany('App\Elevation', 'legacy_post_id');
    }

    public function extension()
    {
        return $this->hasMany('App\Extension', 'legacy_post_id');
    }
}
