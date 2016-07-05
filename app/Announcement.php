<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'description',
    ];

    public function beacon()
    {
        return $this->belongsTo('App\Beacon');
    }
}
