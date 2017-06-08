<?php

namespace App\Http\Controllers\Notifications;

use Carbon\Carbon;

use Nexmo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class NexmoController extends Controller
{
    public function inGoing(Request $request)
    {
        Mail::to('jkinney@msdist.com')->send(new TextResponse($request->all()));

        return response([], 200);
    }

    public function outGoing(Request $request)
    {
        Mail::to('jkinney@msdist.com')->send(new TextResponse($request->all()));

        return response([], 200);
    }

    public function confirmation(Request $request)
    {
        Log::info(json_encode($request->all()));
    }

    public function testing()
    {
        return response(Carbon::now()->toRssString());
    }
}
