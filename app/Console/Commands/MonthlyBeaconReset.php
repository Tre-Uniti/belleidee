<?php

namespace App\Console\Commands;

use App\Beacon;
use Illuminate\Console\Command;
use Event;

class MonthlyBeaconReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'beacon:monthlyBeaconReset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Beacon counters for the month';
    

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $beacons = Beacon::latest()->get();

        foreach($beacons as $beacon)
        {
            $beacon->total_tag_usage = $beacon->total_tag_usage + $beacon->tag_usage;
            $beacon->tag_views = 0;
            $beacon->tag_usage = 0;
            $beacon->update();
        }
        $this->info('Beacon counters successfully reset!');
    }
}
