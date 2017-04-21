<?php

namespace App\Notifications;

use Nexmo\Client;
use Nexmo\Client\Credentials\Basic;

class Text
{
    function __Construct()
    {
        $this->client = new Client(new Basic(env('NEXMO_KEY'), env('NEXMO_SECRET')));
    }

    public function send($request)
    {
        $text = $this->client->message()->send([
			'to' => $request->to,
			'from' => $request->from,
			'text' => $request->text,
		]);

        event(new TextSent($text));
        
		return $text;
    }
}