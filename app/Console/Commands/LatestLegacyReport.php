<?php

namespace App\Console\Commands;

use App\Mailers\NotificationMailer;
use Illuminate\Console\Command;

class LatestLegacyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'legacy:latestLegacyReport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send latest Legacy posts to Idee users';



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
        $notification->sendLatestLegacyReport();
    }

}
