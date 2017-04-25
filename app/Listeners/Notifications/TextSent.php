<?php

namespace App\Listeners\Notifications;

use App\Events\Notifications;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TextSent
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
     * @param  Notifications  $event
     * @return void
     */
    public function handle(Notifications $event)
    {
        //
    }
}
