<?php

namespace App\Listeners;

use App\Beacon;
use App\Events\SetLocation;
use App\Extension;
use App\Post;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RetrieveLatestLocation
{
    /**
     * Create the event listener.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the event.
     *
     * @param  SetLocation  $event
     * @return void
     */
    public function handle(SetLocation $event)
    {
        $user = User::findOrFail($event->user->id);

        $last_tag = $user->last_tag;

        //Global User
        if($last_tag == NULL || $last_tag == 'No-Beacon')
        {
            $coordinates = [
                'lat' => NULL,
                'long' => NULL,
                'country' => NULL,
                'city' => NULL,
                'cityCode' => NULL,
                'cityName' => NULL,
                'shortTag' => NULL,
                'location' => 2,
            ];

            //Set user location to Global in database
            $user->location = 2;
            $user->update();

            $this->flashLocation($user, $coordinates);
            session()->put('coordinates', $coordinates);
        }
        else
        {
            $this->setCoordinates($user, $last_tag);
        }

    }

    //Get beacon tag and set coordinates
    public function setCoordinates($user, $last_tag)
    {
        $beacon = Beacon::where('beacon_tag', '=', $last_tag)->first();
        if($last_tag != 'No-Beacon' && !is_null($beacon))
        {
            $country = $beacon->country;

            //Separate out city code and name
            $cityCode = substr($beacon->beacon_tag, 3);
            $cityCode = substr($cityCode, 0, strpos($cityCode, "-"));
            $cityName = $beacon->city;

            //Add country to city name
            $city = $beacon->country . '-' . $cityName;

            //Add country to city code
            $shortTag = $beacon->country . '-' . $cityCode;

            $coordinates = [
                'lat' => $beacon->lat,
                'long' => $beacon->long,
                'country' => $country,
                'city' => $city,
                'shortTag' => $shortTag,
                'cityCode' => $cityCode,
                'cityName' => $cityName,
                'location' => $user->location,
            ];
            $this->flashLocation($user, $coordinates);
            session()->put('coordinates', $coordinates);
        }
        else
        {
            $coordinates = [
                'lat' => NULL,
                'long' => NULL,
                'country' => NULL,
                'city' => NULL,
                'cityCode' => NULL,
                'cityName' => NULL,
                'shortTag' => NULL,
                'location' => 2,
            ];

            //Set user location to Global in database
            $user->location = 2;
            $user->update();
            $this->flashLocation($user, $coordinates);
            session()->put('coordinates', $coordinates);
        }
    }

    //Flash message to be sent to user once logged in
    public function flashLocation($user, $coordinates)
    {
        //Local
        if($user->location == 0)
        {
            
            if($coordinates['city'] == NULL)
            {
                flash()->overlay('No recently localized content, please set a custom location or request a new beacon');
            }
            else
            {
                flash()->overlay('Greetings ' . $user->handle . ' your location is set to: ' . $coordinates['city']);
            }

        }
        //Country
        elseif($user->location == 1)
        {

            if($coordinates['country'] == NULL)
            {
                flash()->overlay('No recently localized content, you may set a custom location below');
            }
            else
            {
                flash()->overlay('Greetings ' . $user->handle . ' your location is set to: ' . $coordinates['country']);
            }
        }
        //Global
        else
        {
            flash()->overlay('Greetings ' . $user->handle . ' your location is set to: ' . 'Global');
        }
    }
}
