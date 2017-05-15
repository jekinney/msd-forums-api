<?php

namespace App\Listeners\Notifications;

use Nexmo;
use App\Helpers\PhoneNumber;
use App\Events\Notifications\SendTestNotification;

class SendTestText
{
    /**
     * Handle the event.
     *
     * @param  SendTestNotification  $event
     * @return void
     */
    public function handle(SendTestNotification $event)
    {
        if($event->request->type == 'text') {

             Nexmo::message()->send([
                'to' => PhoneNumber::setForText($event->request->to),
                'from' => env('NEXMO_PHONE'),
                'text' => $event->request->message
            ]);
        }
    }
}
