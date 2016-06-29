<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LegacyPost extends Model
{
    protected $fillable = [
        'title',
        'post_path'
    ];

    public function legacy()
    {
        return $this->belongsTo('App\Legacy');
    }

    public function elevations()
    {
        return $this->hasMany('App\Elevation');
    }

    public function extensions()
    {
        return $this->hasMany('App\Extension');
    }
}
