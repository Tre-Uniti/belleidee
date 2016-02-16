<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{

    protected $fillable = [
        'title',
        'pointer',
        'type',

    ];
    /*
     * Get the Users associated with a specific bookmark
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
