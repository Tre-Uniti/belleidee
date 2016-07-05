<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;
use TaxJar;

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

    public function getTaxPercent()
    {

        $zip = $this->zipcode;
        $zip = substr($zip, 0, 2);
        $country = $this->country;

        //Only one nexus in WA therefore only charge sales tax if Beacon is located in WA
        if($zip == 98 && $country == 'US')
        {
            return 8.5;
        }
        else
        {
            return 0;
        }
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
        'guide',
        'manager',
        'lat',
        'long',
        'zip',
    ];

    public function announcement()
    {
        return $this->hasMany('App\Announcement');
    }

}
