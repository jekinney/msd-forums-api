<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Notifications\Notification;

class CheckToSendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if any notifications need processed';

    protected $notification;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $notifications = $this->notification->with('recipients')->whereNull('started_at')->whereNull('completed_at')->where('send_at', '<=', Carbon::now())->get();

        if($notifications->count() > 0) 
        {
            $this->info('Have '.$notifications->count().' to run');

            foreach($notifications as $notification) 
            {
                if($notification->type == 'email') {

                    $email = new Email();
                    $email->sendMany($notification);

                } elseif($notification->type == 'text') {

                    $text = new Text();
                    $text->sendMany($notification);

                }
            }

            return $this->info('All notifications have been processed');
        }

        return $this->line('Nothing needed to process');
    }
}
