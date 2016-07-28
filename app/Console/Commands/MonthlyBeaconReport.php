<?php

namespace App\Console\Commands;

use App\Mailers\NotificationMailer;
use Illuminate\Console\Command;

class MonthlyBeaconReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'beacon:monthlyBeaconReport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send monthly Beacon report to paid subscriptions';
    


    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param NotificationMailer $notification
     * @return mixed
     */
    public function handle(NotificationMailer $notification)
    {
        $notification->sendMonthlyBeaconReport();
        $this->info('Beacon report successfully sent!');
    }
    
}
