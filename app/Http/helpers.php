<?php

namespace App\Http;

use App\Beacon;
use App\Events\BeaconViewed;
use App\Events\SponsorViewed;
use App\Sponsor;
use App\Sponsorship;
use Event;

/*
 * Get the sponsor of a given user
 *
 * @param user
 */
function getSponsor($user)
{
    if(Sponsorship::where('user_id', '=', $user->id)->exists())
    {
        $sponsorship = Sponsorship::where('user_id', '=', $user->id)->first();
        $sponsor = Sponsor::where('id', '=', $sponsorship->sponsor_id)->first();
        Event::fire(new SponsorViewed($sponsor));
        if($sponsor->views >= $sponsor->view_budget || $sponsor->clicks >= $sponsor->click_budget)
        {
            $sponsor = NULL;
        }
    }
    else
    {
        $sponsor = NULL;
    }

    return $sponsor;
}

/*
 * Get the beacon of a given content and return if beacon pays subscription
 *
 * @param content
 */
function getBeacon($content)
{

    $beacon = Beacon::where('beacon_tag', '=', $content->beacon_tag)->first();

    if ($beacon->tier >= 1)
    {
        //Beacon pays subscription for promotions
        Event::fire(new BeaconViewed($beacon));
    }
    else
    {
        $beacon = NULL;
    }

    return $beacon;
}


