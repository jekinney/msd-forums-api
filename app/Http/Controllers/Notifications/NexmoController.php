<?php

namespace App\Http\Controllers\Notifications;

use Nexmo;
use App\Mail\TextResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class NexmoController extends Controller
{
    /**
     * {"msisdn":"13609290280","to":"18889932512","messageId":"0C00000039F054AF","text":"Help","type":"text","keyword":"HELP","message-timestamp":"2017-06-08 19:57:10"} 
     */
    public function reply(Request $request)
    {
        Log::info($request->all());

        return response([], 200);
    }

    public function confirmation(Request $request)
    {
        Log::info(json_encode($request->all()));
        return response([], 200);
    }
}
