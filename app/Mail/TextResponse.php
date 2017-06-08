<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Notifications\Recipient;
use Illuminate\Queue\SerializesModels;

class TextResponse extends Mailable
{
    use SerializesModels;

    protected $recipient;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Recipient $recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('reply to text message')->view('emails.text.response');
    }
}
