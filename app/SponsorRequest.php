<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SponsorRequest extends Model
{
    protected $fillable = [
        'name',
        'adult',
        'website',
        'phone',
        'email',
        'address',
        'country',
        'location',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
