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
        if($sponsor->views >= $sponsor->budget)
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

function getBeaconSponsor($content)
{
    //Check if post has been localized
    if($content->beacon_tag == 'No-Beacon')
    {
        //No Beacon defaults to user's sponsor
        if(Sponsorship::where('user_id', '=', $content->user_id)->exists())
        {
            $sponsorship = Sponsorship::where('user_id', '=', $content->user_id)->first();
            $sponsor = Sponsor::where('id', '=', $sponsorship->sponsor_id)->first();
            if($sponsor->views >= $sponsor->budget)
            {
                $sponsor = NULL;
            }
            Event::fire(new SponsorViewed($sponsor));
        }
        else
        {
            $sponsor = NULL;
        }
        return $sponsor;
    }
    else
    {
        $postBeacon = Beacon::where('beacon_tag', '=', $content->beacon_tag)->first();

        if ($postBeacon->tier > 1)
        {
            //Beacon pays subscription for promotions
            $beacon = $postBeacon;
            Event::fire(new BeaconViewed($beacon));

            return $beacon;
        }
        else
        {
            //Beacon does not subscribe for promotion, default to sponsor
            if (Sponsorship::where('user_id', '=', $content->user_id)->exists())
            {
                $sponsorship = Sponsorship::where('user_id', '=', $content->user_id)->first();
                $sponsor = Sponsor::where('id', '=', $sponsorship->sponsor_id)->first();
                if($sponsor->views >= $sponsor->budget)
                {
                    $sponsor = NULL;
                }
                Event::fire(new SponsorViewed($sponsor));
            }
            else
            {
                $sponsor = NULL;
            }
        }
    }
    return $sponsor;
}


