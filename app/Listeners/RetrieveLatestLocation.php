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

        $post = Post::where('user_id', '=', $user->id)->orderby('created_at', 'desc')->first();
        $extension = Extension::where('user_id', '=', $user->id)->orderby('created_at', 'desc')->first();

        if(is_null($post) && is_null($extension))
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

        //Set location of user based off of post location
        elseif(!is_null($post) && is_null($extension))
        {
            $this->setCoordinates($user, $post);
        }
        //Set location of user based off of extension location
        elseif(is_null($post) && !is_null($extension))
        {
            $this->setCoordinates($user, $extension);
        }

        //Set location if post was created before latest extension
        elseif($post->created_at >= $extension->created_at)
        {
            $this->setCoordinates($user, $post);
        }

        //Set location if post was created after latest extension
        elseif($post->created_at <= $extension->created_at)
        {
            $this->setCoordinates($user, $extension);
        }
    }

    //Get beacon tag and set coordinates
    public function setCoordinates($user, $content)
    {
        $beacon = Beacon::where('beacon_tag', '=', $content->beacon_tag)->first();
        if($content->beacon_tag != 'No-Beacon' && !is_null($beacon))
        {

            $country = $beacon->country;

            //Separate out city code and name
            $cityCode = substr($beacon->beacon_tag, strpos($beacon->beacon_tag, "-"));
            $cityCode = substr($cityCode, strpos($cityCode, "-"));
            $cityName = $beacon->city;

            //Add country to city name
            $city = $beacon->country . '-' . $cityName;

            //Add country to city code
            $shortTag = $beacon->country . $cityCode;

            $coordinates = [
                'lat' => $content->lat,
                'long' => $content->long,
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
            if($coordinates['city'] == '-')
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
