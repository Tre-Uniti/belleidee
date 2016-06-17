<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'description',
        'promo',
        'status'
    ];

    public function sponsor()
    {
        return $this->belongsTo('App\Sponsor');
    }

}
