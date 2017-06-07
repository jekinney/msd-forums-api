<?php

namespace App\Http\Controllers\Notifications;

use Nexmo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class NexmoController extends Controller
{
    public function inGoing(Request $request)
    {
        Log::info(json_encode($request->all()));
        
        return response([], 200);
    }

    public function outGoing(Request $request)
    {
        Log::info(json_encode($request->all()));

        return response([], 200);
    }

    public function confirmation(Request $request)
    {
        Log::info(json_encode($request->all()));
    }

    public function testing()
    {
        $request = Nexmo::message()->send([
            'to' => 13609290280,
            'from' => env('NEXMO_PHONE'),
            'text' => 'call back test',
            'callback' => 'https://laravelopers.com/api/v1/notifications/nexmo/confirmation'
        ]);

        dd($request['messages'][0]['message-id']);
    }
}
