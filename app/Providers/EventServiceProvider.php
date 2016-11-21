<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\PostExtended' => [
            'App\Listeners\UserPostNotification',
        ],
        'App\Events\SponsorViewed' => [
            'App\Listeners\ChargeSponsor',
        ],
        'App\Events\BeaconViewed' => [
            'App\Listeners\UpdateBeaconUsage'
        ],
        'App\Events\TransferUser' => [
            'App\Listeners\TransferUserContent'
        ],
        'App\Events\SetLocation' => [
            'App\Listeners\RetrieveLatestLocation'
        ],
        'App\Events\BeliefInteraction' => [
            'App\Listeners\UpdateBeliefCounter'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
