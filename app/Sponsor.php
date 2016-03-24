<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = [
        'name',
        'website',
        'address',
        'phone',
        'photo_path',
        'budget',
        'adult',
        'country',
        'location',
        'email',
    ];
}
