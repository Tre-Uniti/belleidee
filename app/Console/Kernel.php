<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Storage;

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
        Commands\MonthlySponsorReport::class,
        Commands\LatestLegacyReport::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $filePath = Storage::disk('local');
        //$schedule->command('inspire')
                 //->hourly();

        //Latest Legacy Report
        $schedule->command('latestLegacyReport')->Weekly()->sundays()->at('7:00')
                    ->sendOutputTo($filePath)
                    ->emailOutputTo('tre-uniti@belle-idee.org')
                    ->pingBefore('http://beats.envoyer.io/heartbeat/xVDhFSK4jA0LbWA')
                    ->thenPing('http://beats.envoyer.io/heartbeat/xVDhFSK4jA0LbWA');

        //Monthly reports
        $schedule->command('monthlyBeaconReport')->Monthly()
                    ->sendOutputTo($filePath)
                    ->emailOutputTo('tre-uniti@belle-idee.org')
                    ->pingBefore('http://beats.envoyer.io/heartbeat/xVDhFSK4jA0LbWA	')
                    ->thenPing('http://beats.envoyer.io/heartbeat/xVDhFSK4jA0LbWA	');

        $schedule->command('monthlyBeaconReset')->Monthly()
                    ->sendOutputTo($filePath)
                    ->emailOutputTo('tre-uniti@belle-idee.org')
                    ->pingBefore('http://beats.envoyer.io/heartbeat/sJMQyFYadJ1mpBw')
                    ->thenPing('http://beats.envoyer.io/heartbeat/sJMQyFYadJ1mpBw');

        $schedule->command('monthlySponsorReport')->Monthly()
                    ->sendOutputTo($filePath)
                    ->emailOutputTo('tre-uniti@belle-idee.org')
                    ->pingBefore('http://beats.envoyer.io/heartbeat/fns0wM10UnkF2h4	')
                    ->thenPing('http://beats.envoyer.io/heartbeat/fns0wM10UnkF2h4	');

        //Run daily backups to S3 and local
        $schedule->command('backup:clean')->daily()->at('01:00')
                    ->appendOutputTo($filePath)
                    ->emailOutputTo('tre-uniti@belle-idee.org')
                    ->pingBefore('http://beats.envoyer.io/heartbeat/pmD4rGlycwLlIkg	')
                    ->thenPing('http://beats.envoyer.io/heartbeat/pmD4rGlycwLlIkg');

        $schedule->command('backup:run')->daily()->at('02:00')
                    ->appendOutputTo($filePath)
                    ->emailOutputTo('tre-uniti@belle-idee.org')
                    ->pingBefore('http://beats.envoyer.io/heartbeat/063hSXI4bQV8lfC')
                    ->thenPing('http://beats.envoyer.io/heartbeat/063hSXI4bQV8lfC');
        
    }
}
