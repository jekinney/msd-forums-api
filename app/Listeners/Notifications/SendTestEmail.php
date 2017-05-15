<?php

namespace App\Listeners\Notifications;

use App\Mail\Notifications\Test;
use Illuminate\Support\Facades\Mail;
use App\Events\Notifications\SendTestNotification;

class SendTestEmail
{
    /**
     * Handle the event.
     *
     * @param  SendTestNotification  $event
     * @return void
     */
    public function handle(SendTestNotification $event)
    {
        if($event->request->type == 'email') {

            Mail::to($event->request->test_to)->send(new Test($event->request->message));
        }
    }
}
