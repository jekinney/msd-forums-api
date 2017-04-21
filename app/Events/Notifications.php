<?php

namespace App\Events;

use App\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class Notifications
{
    public $data;
    public $notification;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data, Notification $notification)
    {
        $this->data = $data;
        $this->notification = $notification;
    }
}
