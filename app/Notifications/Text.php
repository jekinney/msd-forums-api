<?php

namespace App\Notifications;

use Nexmo;
use App\Events\Notifications\TextSent;
use App\Events\Notifications\TextReceipt;
class Text
{
    /**
     * Send one or many text messages
     * Data is taken from then notification
     * object
     *
     * @param object $notification
     */
    public function sendMany($notification) 
    {
        foreach($notification->recipients as $recipient) {
            $this->send($recipient, $notification->message);
            sleep(1);
        }

        return $notification->isCompleted();
    }   

    /**
     * Send one text message with
     * explicent data sent through
     *
     * @param object $recipient
     * @param string $message
     */
    public function send($recipient, $message)
    {
        $request = Nexmo::message()->send([
            'to' => $recipient->connection,
            'from' => env('NEXMO_PHONE'),
            'text' => $message
        ]);

        //event(new TextSent($request, $recipient));
    }

    /**
     * Call back from Nexmo for 
     * incoming SMS/Text
     */
    public function incoming($request)
    {
        if($request->has('messageId') || $request->has('status')) {
            return $this->receipt($request);
        }
        return $this->message($request);
    }

    protected function receipt($request)
    {
        return event( new TextReceipt($request));
    }

    protected function message($request)
    {

    }
}