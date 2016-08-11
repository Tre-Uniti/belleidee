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
        if (Storage::disk('local')->exists('/reports/legacyReports.txt'))
        {
            $legacyReportFile = Storage::disk('local')->get('/reports/legacyReports.txt');
        }
        else
        {
            $legacyReportFile = Storage::disk('local')->put('/reports/legacyReports.txt', 'Initial');
        }
        if (Storage::disk('local')->exists('/reports/beaconReports.txt'))
        {
            $beaconReportFile = Storage::disk('local')->get('/reports/beaconReports.txt');
        }
        else
        {
            $beaconReportFile = Storage::disk('local')->put('/reports/beaconReports.txt', 'Initial');
        }
        if (Storage::disk('local')->exists('/reports/beaconResets.txt'))
        {
            $beaconResetFile = Storage::disk('local')->get('/reports/beaconResets.txt');
        }
        else
        {
            $beaconResetFile = Storage::disk('local')->put('/reports/beaconResets.txt', 'Initial');
        }
        if (Storage::disk('local')->exists('/reports/sponsorReports.txt'))
        {
            $sponsorReportFile = Storage::disk('local')->get('/reports/sponsorReports.txt');
        }
        else
        {
            $sponsorReportFile = Storage::disk('local')->put('/reports/sponsorReports.txt', 'Initial');
        }
        if (Storage::disk('local')->exists('/reports/backupReports.txt'))
        {
            $backupReportFile = Storage::disk('local')->get('/reports/backupReports.txt');
        }
        else
        {
            $backupReportFile = Storage::disk('local')->put('/reports/backupReports.txt', 'Initial');
        }

        //$backupReportFile = $storagePath . '/reports/' . 'backupReport.txt';
        //$schedule->command('inspire')
                 //->hourly();

        /*Latest Legacy Report
        $schedule->command('legacy:latestLegacyReport')->Weekly()->sundays()->at('7:00')
                    ->appendOutputTo($legacyReportFile)
                    ->emailOutputTo('tre-uniti@belle-idee.org')
                    ->pingBefore('http://beats.envoyer.io/heartbeat/xVDhFSK4jA0LbWA')
                    ->thenPing('http://beats.envoyer.io/heartbeat/xVDhFSK4jA0LbWA');
        */
        //Monthly reports
        $schedule->command('beacon:monthlyBeaconReport')->everyMinute()
                    ->appendOutputTo($beaconReportFile)
                    ->emailOutputTo('tre-uniti@belle-idee.org')
                    ->pingBefore('http://beats.envoyer.io/heartbeat/xVDhFSK4jA0LbWA	')
                    ->thenPing('http://beats.envoyer.io/heartbeat/xVDhFSK4jA0LbWA	');

        $schedule->command('beacon:monthlyBeaconReset')->Monthly()
                    ->appendOutputTo($beaconResetFile)
                    ->emailOutputTo('tre-uniti@belle-idee.org')
                    ->pingBefore('http://beats.envoyer.io/heartbeat/sJMQyFYadJ1mpBw')
                    ->thenPing('http://beats.envoyer.io/heartbeat/sJMQyFYadJ1mpBw');

        $schedule->command('sponsor:monthlySponsorReport')->Monthly()
                    ->appendOutputTo($sponsorReportFile)
                    ->emailOutputTo('tre-uniti@belle-idee.org')
                    ->pingBefore('http://beats.envoyer.io/heartbeat/fns0wM10UnkF2h4	')
                    ->thenPing('http://beats.envoyer.io/heartbeat/fns0wM10UnkF2h4	');

        //Run daily backups to S3 and local
        $schedule->command('backup:clean')->daily()->at('01:00')
                    ->appendOutputTo($backupReportFile)
                    ->emailOutputTo('tre-uniti@belle-idee.org')
                    ->pingBefore('http://beats.envoyer.io/heartbeat/pmD4rGlycwLlIkg	')
                    ->thenPing('http://beats.envoyer.io/heartbeat/pmD4rGlycwLlIkg');

        $schedule->command('backup:run')->daily()->at('02:00')
                    ->appendOutputTo($backupReportFile)
                    ->emailOutputTo('tre-uniti@belle-idee.org')
                    ->pingBefore('http://beats.envoyer.io/heartbeat/063hSXI4bQV8lfC')
                    ->thenPing('http://beats.envoyer.io/heartbeat/063hSXI4bQV8lfC');
        
    }
}
