<?php

namespace App\Notifications\Traits;

use Nexmo;
use App\Helpers\PhoneNumber;
use App\Events\Notifications\TextSent;
use App\Events\Notifications\TextReceipt;

trait NeximoTexts
{
	public function sendTest($notification) 
    {
        Nexmo::message()->send([
            'to' => PhoneNumber::setForText($notification->from),
            'from' => env('NEXMO_PHONE'),
            'text' => $notification->message
        ]);
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