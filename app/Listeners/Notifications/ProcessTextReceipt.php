<?php

namespace App\Listeners\Notifications;

use App\Events\Notifications\TextReceipt;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessTextReceipt
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
     * @param  TextReceipt  $event
     * @return void
     */
    public function handle(TextReceipt $event)
    {
        //
    }
}
