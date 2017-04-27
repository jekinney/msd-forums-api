<?php

namespace App\Mail\Notifications;

use Illuminate\Mail\Mailable;
use App\Notifications\Recipient;
use App\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class Basic extends Mailable
{
    use SerializesModels;

    public $notification;

    public $recipient;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Notification $notification, Recipient $recipient)
    {
        $this->notification = $notification;
        $this->recipient = $recipient;
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
