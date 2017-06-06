<?php

namespace App\Mail\Notifications;

use Illuminate\Mail\Mailable;
use App\Notifications\Email;
use App\Notifications\Recipient;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Basic extends Mailable
{
    use SerializesModels;


    public $email, $recipient;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Email $email, Recipient $recipient)
    {
        $this->email = $email;
        $this->recipient = $recipient;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->email->subject)->markdown('emails.notifications.basic');
    }
}
