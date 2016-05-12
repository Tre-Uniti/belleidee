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
        //$schedule->command('inspire')
                 //->hourly();

        //Run daily backups to S3 and local
        $schedule->command('backup:clean')->daily()->at('01:00')
                    ->pingBefore('http://beats.envoyer.io/heartbeat/pmD4rGlycwLlIkg	')
                    ->thenPing('http://beats.envoyer.io/heartbeat/pmD4rGlycwLlIkg');

        $schedule->command('backup:run')->daily()->at('02:00')
                    ->pingBefore('http://beats.envoyer.io/heartbeat/063hSXI4bQV8lfC')
                    ->thenPing('http://beats.envoyer.io/heartbeat/063hSXI4bQV8lfC');

        $schedule->call(function () {
            //Event::fire(New monthlyBeaconReset());


        })->everyMinute()->pingBefore('http://beats.envoyer.io/heartbeat/sJMQyFYadJ1mpBw')
            ->thenPing('http://beats.envoyer.io/heartbeat/sJMQyFYadJ1mpBw');

        //Run Beacon Subscriptions Email and reset tag usage
        /*$schedule->command('emails:send')
        ->monthly()
        ->pingBefore($url)
        ->thenPing($url);*/
    }
}
