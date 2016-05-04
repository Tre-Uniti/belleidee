<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
        //$schedule->command('backup:clean')->daily()->at('01:00');
        //$schedule->command('backup:run')->daily()->at('02:00');

        //Run Beacon Subscriptions Email and reset tag usage
        /*$schedule->command('emails:send')
        ->monthly()
        ->pingBefore($url)
        ->thenPing($url);*/
    }
}
