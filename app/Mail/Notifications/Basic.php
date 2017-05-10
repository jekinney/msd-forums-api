<?php

namespace App\Mail\Notifications;

use Illuminate\Mail\Mailable;
use App\Notifications\Notification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Basic extends Mailable
{
    use SerializesModels;


    public $notification;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->notification->subject)->markdown('emails.notifications.basic');
    }
}
