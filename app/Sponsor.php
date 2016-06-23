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
        'view_budget',
        'click_budget',
        'adult',
        'country',
        'city',
        'email',
        'user_id',
        'lat',
        'long',
        'zip',
        'sponsor_tag',
    ];

    public function sponsorship()
    {
        $this->hasMany('App\Sponsorship');
    }

    public function promotion()
    {
        $this->hasOne('App\Promotion');
    }
}
