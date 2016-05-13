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
        Commands\Inspire::class,
        Commands\MonthlyBeaconReport::class,
        Commands\MonthlyBeaconReset::class,
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
        $schedule->command('monthlyBeaconReport')->everyMinute()
                    ->pingBefore('http://beats.envoyer.io/heartbeat/xVDhFSK4jA0LbWA	')
                    ->thenPing('http://beats.envoyer.io/heartbeat/xVDhFSK4jA0LbWA	');

        $schedule->command('monthlyBeaconReset')->everyFiveMinutes()
                    ->pingBefore('http://beats.envoyer.io/heartbeat/sJMQyFYadJ1mpBw')
                    ->thenPing('http://beats.envoyer.io/heartbeat/sJMQyFYadJ1mpBw');

        //Run daily backups to S3 and local
        $schedule->command('backup:clean')->daily()->at('01:00')
                    ->pingBefore('http://beats.envoyer.io/heartbeat/pmD4rGlycwLlIkg	')
                    ->thenPing('http://beats.envoyer.io/heartbeat/pmD4rGlycwLlIkg');

        $schedule->command('backup:run')->daily()->at('02:00')
                    ->pingBefore('http://beats.envoyer.io/heartbeat/063hSXI4bQV8lfC')
                    ->thenPing('http://beats.envoyer.io/heartbeat/063hSXI4bQV8lfC');
        
    }
}
