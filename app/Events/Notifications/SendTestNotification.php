<?php

namespace App\Events\Notifications;

use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class SendTestNotification
{
    use SerializesModels;

    public $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
