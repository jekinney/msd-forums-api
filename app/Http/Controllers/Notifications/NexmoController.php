<?php

namespace App\Http\Controllers\Notifications;

use Nexmo;
use App\Mail\TextResponse;
use Illuminate\Http\Request;
use App\Notifications\Recipient;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class NexmoController extends Controller
{
    public function reply(Request $request)
    {
        if($request['msisdn'] == 19033059009 || $request['msisdn'] == '19033059009') {
            $this->tellAustinOff();
        } else {
            $recipient = Recipient::where('phone', $request['msisdn'])->first();
            if($recipient) {
                $recipient->update(['notes' => $request['text']]);

                $emails = [
                    'jkinneys@msdist.com',
                    // 'AReynolds@MSDist.com',
                    // 'PSoules@MSDist.com',
                    // 'CThompson@MSDist.com',
                ];

                foreach($emails as $email) {
                    Mail::to($email)->send(new TextResponse($recipient));
                }
            }
        }

        return response([], 200);
    }

    public function confirmation(Request $request)
    {
        return response([], 200);
    }

    protected function tellAustinOff() 
    {
        return Nexmo::message()->send([
            'to' => 19033059009,
            'from' => env('NEXMO_PHONE'),
            'text' => 'Stop it private, you are wasting money!!!!!!!'
        ]);
    }
}
