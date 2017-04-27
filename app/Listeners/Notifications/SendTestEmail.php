<?php

namespace App\Listeners\Notifications;

use App\Notifications\Email;
use App\Events\Notifications\SendTestNotification;

class SendTestEmail
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
     * @param  SendTestNotification  $event
     * @return void
     */
    public function handle(SendTestNotification $event)
    {
        if($event->request->type == 'email') {

            $this->email->sendTest($event->request);
        }
    }
}
