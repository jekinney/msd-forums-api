<?php

namespace App\Listeners\Notifications;

use Carbon\Carbon;
use App\Notifications\Text;
use App\Events\Notifications\ProcessNotification;

class SendTexts
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
     * @param  ProcessNotification  $event
     * @return void
     */
    public function handle(ProcessNotification $event)
    {
        if($this->event->notification->type == 'text') {

            $notification->update(['started_at' => Carbon::now()]);

            $this->text->sendMany($notification->load('recipients'));
        }
    }
}
