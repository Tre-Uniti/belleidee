<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beacon extends Model
{
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
