<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'published_at',
        'belief',
        'beacon_tag',
        'source',
        'caption',
        'post_path',
        'lat',
        'long',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function elevation()
    {
        return $this->hasMany('App\Elevate');
    }

    public function extensions()
    {
        return $this->hasMany('App\Extension');
    }

    /**
     * Additional fields to treat as Carbon instances.
     *
     * @var array
     */
    protected $date = ['created_at'];

    /**
     * Scope queries to articles that have been published.
     *
     * @param $query
     */
    public function scopePublished($query)
    {
        $query->where('created_at', '>=', Carbon::now());
    }




}
