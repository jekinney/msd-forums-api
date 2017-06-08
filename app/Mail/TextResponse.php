<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Notifications\Recipient;
use Illuminate\Support\Facades\Log;
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
        Log::info($this->recipient);
        
        return $this->subject('reply to text message')
            ->view('emails.text.response')
            ->with([
                'name' => $this->recipient->name,
                'phone' => $this->recipient->phone,
                'email' => $this->recipient->email,
                'text' => $this->recipient->notes,
            ]);
    }
}
