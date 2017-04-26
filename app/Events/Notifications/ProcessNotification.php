<?php

namespace App\Events\Notifications;

use App\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class ProcessNotification
{
    use SerializesModels;

    public $notification;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }
}
