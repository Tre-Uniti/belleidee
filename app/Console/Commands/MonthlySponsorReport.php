<?php

namespace App\Console\Commands;

//use App\Mailers\NotificationMailer;
use App\Mailers\NotificationMailer;
use Illuminate\Console\Command;

class MonthlySponsorReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sponsor:monthlySponsorReport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send monthly Sponsor report';


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
        $notification->sendMonthlySponsorReport();
    }
}
