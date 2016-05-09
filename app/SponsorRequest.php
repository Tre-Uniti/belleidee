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

        static::creating(function($sponsorRequest)
        {
            $sponsorRequest->status = 'Requested';
            $sponsorRequest->admin = 'Tre-Uniti';
        });
    }
}
