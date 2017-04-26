<?php

namespace App\Listeners\Notifications;

use App\Events\Notifications\TextSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetTextStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TextSent  $event
     * @return void
     */
    public function handle(TextSent $event)
    {
         $message = $this->event->request->getResponseData()['messages'][0];

        $this->event->recipient->update([
            'message_id' => $message['message-id'],
            'status' => $message['status'],
            'started_at' => \Carbon\Carbon::now(),
            'price' => $message['message-price']
        ]);
    }
}
