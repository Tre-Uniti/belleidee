<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\SearchIndex\Searchable;

class Post extends Model implements Searchable
{
    protected $fillable = [
        'title',
        'body',
        'published_at',
        'belief',
        'beacon_tag',
        'category',
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

    /**
     * Returns an array with properties which must be indexed
     *
     * @return array
     */
    public function getSearchableBody()
    {
        $searchableProperties = [
            'title' => $this->title,
            'belief' => $this->belief,
            'beacon_tag' => $this->beacon_tag,
            'category' => $this->category
        ];


        return $searchableProperties;

    }

    /**
     * Return the type of the searchable subject
     *
     * @return string
     */
    public function getSearchableType()
    {
        return 'post';
    }

    /**
     * Return the id of the searchable subject
     *
     * @return string
     */
    public function getSearchableId()
    {
        return $this->id;
    }



}
