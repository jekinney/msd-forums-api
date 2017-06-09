<?php

namespace App\Notifications\Traits;

use Nexmo;
use Carbon\Carbon;
use App\Helpers\PhoneNumber;

trait NeximoTexts
{
	public function sendTest() 
    {
        Nexmo::message()->send([
            'to' => PhoneNumber::setForText(request('to')),
            'from' => env('NEXMO_PHONE'),
            'text' => request('message')
        ]);
    }

    // /**
    //  * Call back from Nexmo for 
    //  * incoming SMS/Text
    //  */
    // public function incoming($request)
    // {
    //     if($request->has('messageId') || $request->has('status')) {
    //         return $this->receipt($request);
    //     }
    //     return $this->message($request);
    // }

    public function checkAndSend($stop)
    {
        $texts = $this->with('recipients')->where('send_at', '<', $stop)->whereNull('started_at')->get();

        foreach($texts as $text) {
            $text->update(['started_at' => Carbon::now()]);

            foreach($text->recipients as $person) {
                $person->sent_at = Carbon::now();
                $person->save();

                try {

                    $response = Nexmo::message()->send([
                        'to' => PhoneNumber::setForText($person->phone),
                        'from' => env('NEXMO_PHONE'),
                        'text' => $text->message
                    ]);

                    $person->status = 'sent';
                    $person->message_id = $response['messages'][0]['message-id'];
                    $person->save();

                } catch (Exception $e) {
                    $person->status = 'error';
                    $person->notes = $e;
                    $person->save();
                }
            }
            $text->update(['completed_at' => Carbon::now(), 'notes' => 'Completed']);
        }

        return $texts->count();
    }
}