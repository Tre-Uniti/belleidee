<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
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
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
