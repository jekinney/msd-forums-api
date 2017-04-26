<?php

namespace App\Events\Notifications;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class TextSent
{
    use SerializesModels;

    public $request;

    public $recipient;

    /**
     * Create a new event instance.
     * 
     * @param object $request
     * @param Recipient $recipient
     * @return void
     */
    public function __construct($request, Recipient $recipient)
    {
        $this->request = $request;
        $this->recipient = $recipient;
    }
}
