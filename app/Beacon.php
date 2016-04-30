<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;

class Beacon extends Model implements BillableContract
{

    use Billable;

    /**
     * New Beacons don't need to provide a card right away.
     *
     * @var bool
     */
    protected $cardUpFront = false;
    protected $dates = ['trial_ends_at', 'subscription_ends_at'];

    public function getTaxPercent() {
        return 8.25;
    }


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
        'address',
        'country',
        'city',
        'tier',
        'guide',
        'manager',
        'lat',
        'long',
    ];

}
