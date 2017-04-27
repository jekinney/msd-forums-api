<?php

namespace App\Listeners\Notifications;

use Carbon\Carbon;
use App\Notifications\Email;
use App\Events\Notifications\ProcessNotification;

class SendEmails
{
    protected $email;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * Handle the event.
     *
     * @param  ProcessNotification  $event
     * @return void
     */
    public function handle(ProcessNotification $event)
    {
        if($event->notification->type == 'email') {

            $event->notification->update(['started_at' => Carbon::now()]);

            $this->email->sendMany($event->notification->load('recipients'));
        }
    }
}
