<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BeaconRequest extends Model
{
    protected $fillable = [
        'name',
        'belief',
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
