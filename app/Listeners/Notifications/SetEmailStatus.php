<?php

namespace App\Listeners\Notifications;

use App\Events\Notifications\EmailSent ;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetEmailStatus
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
     * @param  EmailSent   $event
     * @return void
     */
    public function handle(EmailSent  $event)
    {
        //
    }
}
