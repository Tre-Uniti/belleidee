<?php

namespace App\Console;

use App\Beacon;
use App\Events\MonthlyBeaconReset;
use App\Mailers\NotificationMailer;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Event;

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
        
        //Run daily backups to S3 and local
        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('02:00');

        $schedule->call(function (NotificationMailer $mailer) {

            //Get Beacons with a paid subscription
            $beacons = Beacon::where('stripe_plan', '>', 0)->get();
            
            $mailer->sendMonthlyBeaconReport($beacons);
            
            //
            Event::fire(New monthlyBeaconReset($beacons));            
            /*Reset monthly counters for each beacon
            foreach($beacons as $beacon)
            {
                $beacon->views = 0;
                $beacon->tag_usage = 0;
                $beacon->total_usage = $beacon->total_usage + $beacon->tag_usage;
                $beacon->update();
            }*/
        })->everyMinute();

        //Run Beacon Subscriptions Email and reset tag usage
        /*$schedule->command('emails:send')
        ->monthly()
        ->pingBefore($url)
        ->thenPing($url);*/
    }
}
