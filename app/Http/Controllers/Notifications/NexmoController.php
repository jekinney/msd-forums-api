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

    public function reply(Request $request)
    {
        Log::info(json_encode($request->all()));

        return response([], 200);
    }

    public function confirmation(Request $request)
    {
        Log::info(json_encode($request->all()));
        return response([], 200);
    }
}
