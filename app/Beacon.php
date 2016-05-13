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

        /*$taxjar = TaxJar\Client::withApiKey($_ENV['TAXJAR_API_KEY']);
        
        $country = $this->country;
        $city = $this->city;

        if($country == 'US')
        {
            $zip = $this->zip;

            //Idee is based in WA, USA.  Check if ZIP is within WA
            if((98000 <= $zip) && ($zip <= 99400))
            {
                // United States (ZIP w/ Optional Params)
                $rates = $taxjar->ratesForLocation($zip, [
                    'city' => 'SEDRO WOOLLEY',
                    'country' => 'US'
                ]);
                //dd($rates);
                return 8.25;
            }
        }*/

        return 0;
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

}
