<?php

namespace App\Console\Commands;

use App\Mailers\NotificationMailer;
use Illuminate\Console\Command;
use Event;

class MonthlyBeaconReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:monthlyBeaconReset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset beacon counters and email reports to paid subscriptions';

    /**
     * The notification e-mail service.
     *
     * @var NotificationMailer
     */
    protected $notification;

    /**
     * Create a new command instance.
     *
     * @param NotificationMailer $notification
     * @return void
     */
    public function __construct(NotificationMailer $notification)
    {
        parent::__construct();

        $this->notification = $notification;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->notification->sendMonthlyBeaconReport();
        
    }
}
