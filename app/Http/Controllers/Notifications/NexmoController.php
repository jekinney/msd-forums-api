<?php

namespace App\Http\Controllers\Notifications;

use Nexmo;
use App\Mail\TextResponse;
use Illuminate\Http\Request;
use App\Notifications\Recipient;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class NexmoController extends Controller
{
    /**
     * {"msisdn":"13609290280","to":"18889932512","messageId":"0C00000039F054AF","text":"Help","type":"text","keyword":"HELP","message-timestamp":"2017-06-08 19:57:10"} 
     */
    public function reply(Request $request)
    {
        $reply = json_encode($request->all());

        Log::info(json_decode($reply)['msisdn']);

        return response([], 200);

        if($request['msisdn'] != '13609290280') { //'19033059009') {
            $recipient = Recipient::where('phone', $request['msisdn'])->where('message_id', $request['emssageId'])->first();

            $this->sendMail(array_add($recipient, 'text', $request['text']));
            
            return response([], 200);
        } else {
            $this->tellAustinOff();

            return response([], 200);
        }

    }

    public function confirmation(Request $request)
    {
        return response([], 200);
    }

    protected function sendMail($response) 
    {
        $emails = [
            'jkinneys@msdist.com',
            'AReynolds@MSDist.com',
            'PSoules@MSDist.com',
            'CThompson@MSDist.com',
        ];

        Mail::to($emails)->send(new TextResponse($response));
    }

    protected function tellAustinOff() 
    {
        return Nexmo::message()->send([
            'to' => '13069290280', // 19033059009,
            'from' => env('NEXMO_PHONE'),
            'text' => 'Stop it private, you are wasting money!!!!!!!'
        ]);
    }
}
