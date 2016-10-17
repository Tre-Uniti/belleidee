<?php

namespace App\Listeners;

use App\Beacon;
use App\Events\SetLocation;
use App\Extension;
use function App\Http\setCoordinates;
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

            //$this->flashLocation($user, $coordinates);
            session()->put('coordinates', $coordinates);
        }
        else
        {
            setCoordinates($user, $last_tag);
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
                flash()->overlay('Your location is set to: ' . $coordinates['city']);
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
                flash()->overlay('Your location is set to: ' . $coordinates['country']);
            }
        }
        //Global
        else
        {
            flash()->overlay('Your location is set to: ' . 'Global');
        }
    }
}
