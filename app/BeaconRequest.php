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
        'city',
        'status',
        'admin',
        'zip',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($beaconRequest)
        {
            $beaconRequest->status = 'Requested';
            $beaconRequest->admin = 'Tre-Uniti';
        });
    }
}
