<?php

namespace App\Notifications\Observers

use App\Notifications\Notification;

class Notifications
{
	/**
     * Listen to the Notification updated event.
     *
     * @param  Notification  $notification
     * @return void
     */
    public function updated(Notification $notification)
    {
    	foreach($notification->recipients as $recipient) {
            $recipient->delete();
        }
    }
}