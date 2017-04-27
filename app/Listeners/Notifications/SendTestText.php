<?php

namespace App\Listeners\Notifications;

use App\Notifications\Text;
use App\Events\Notifications\SendTestNotification;

class SendTestText
{
    protected $text;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Text $text)
    {
        $this->text = $text;
    }

    /**
     * Handle the event.
     *
     * @param  SendTestNotification  $event
     * @return void
     */
    public function handle(SendTestNotification $event)
    {
        if($event->request->type == 'text') {

            $this->text->sendTest($event->request);
        }
    }
}
