<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beacon extends Model
{

    /**
     * New Beacons don't need to provide a card right away.
     *
     * @var bool
     */
    protected $cardUpFront = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $fillable = [
        'name',
        'beacon_tag',
        'belief',
        'website',
        'phone',
        'email',
        'address'
    ];

}
