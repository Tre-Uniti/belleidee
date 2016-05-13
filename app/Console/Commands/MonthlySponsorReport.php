<?php

namespace App\Console\Commands;

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
     * The drip e-mail service.
     *
     * @var NotificationMailer
     */
    protected $notification;

    /**
     * Create a new command instance.
     *
     * @param NotificationMailer $notification
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
        $this->notification->sendMonthlySponsorReport();
    }
}
